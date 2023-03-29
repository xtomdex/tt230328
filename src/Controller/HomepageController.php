<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/', name: 'homepage', methods: ['GET'])]
final class HomepageController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->json('Welcome to the app');
    }
}
