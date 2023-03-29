<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\UseCase\User\List;

#[Route(path: 'users', name: 'users_list', methods: ['GET'])]
final class UsersListController extends AbstractController
{
    public function __invoke(Request $request, UserRepository $userRepository): Response
    {
        $filter = new List\Filter();
        $form = $this->createForm(List\Form::class, $filter);
        $form->handleRequest($request);

        $users = $userRepository->findAllWithFilter($filter);
        return $this->json(['count' => count($users), 'users' => array_map(function (User $user) {
            return [
                'id' => $user->getId(),
                'type' => $user->getUserType(),
                'isActive' => $user->getIsActive(),
                'lastLoginAt' => $user->getLastLoginAt()->format('Y-m-d')
            ];
        }, $users)]);

    }
}
