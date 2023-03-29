<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\HttpFoundation\Request;
use App\UseCase\User\List;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

#[Rest\Route(path: 'users', name: 'users_list', methods: ['GET'])]
#[Rest\View(serializerGroups: ['users_list', 'paginate'])]
#[OA\Parameter(
    name: 'is_active',
    description: 'The field to filter users by is_active property (0 or 1)',
    in: 'query',
    required: false,
    schema: new OA\Schema(type: 'integer')
)]
#[OA\Parameter(
    name: 'is_member',
    description: 'The field to filter users by is_member property (0 or 1)',
    in: 'query',
    required: false,
    schema: new OA\Schema(type: 'integer')
)]
#[OA\Parameter(
    name: 'user_type[]',
    description: 'The field to filter users by their types (multiple values are allowed)',
    in: 'query',
    required: false,
    schema: new OA\Schema(type: 'array', items: new OA\Items(type: 'integer'))
)]
#[OA\Parameter(
    name: 'last_login_from',
    description: 'The field to filter users by their last login property',
    in: 'query',
    required: false,
    schema: new OA\Schema(type: 'date', format: 'YYYY-MM-DD')
)]
#[OA\Parameter(
    name: 'last_login_to',
    description: 'The field to filter users by their last login property',
    in: 'query',
    required: false,
    schema: new OA\Schema(type: 'date', format: 'YYYY-MM-DD')
)]
#[OA\Response(
    response: Response::HTTP_OK,description: 'Returns paginated filtered users list',
    content: new OA\JsonContent(
        properties: [
            new OA\Property(property: 'pageCount', type: 'integer'),
            new OA\Property(property: 'itemsPerPage', type: 'integer'),
            new OA\Property(property: 'totalItemCount', type: 'integer'),
            new OA\Property(property: 'currentPage', type: 'integer'),
            new OA\Property(property: 'items', type: 'array', items: new OA\Items(ref: new Model(type: User::class, groups: ['users_list'])))
        ],
        type: 'object'
    )
)]
#[OA\Tag(name: 'Users')]
final class UsersListController extends AbstractFOSRestController
{
    public function __invoke(Request $request, UserRepository $userRepository): View
    {
        $filter = new List\Filter();
        $form = $this->createForm(List\Form::class, $filter);
        $form->handleRequest($request);

        $page = $request->query->get('page', 1);
        $limit = $request->query->get('limit', 25);

        $users = $userRepository->findAllWithFilter($filter, $page, $limit);

        return $this->view($users);
    }
}
