<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\UserRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use App\UseCase\User\List;

#[Rest\Route(path: 'users', name: 'users_list', methods: ['GET'])]
#[Rest\View(serializerGroups: ['users_list', 'paginate'])]
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
