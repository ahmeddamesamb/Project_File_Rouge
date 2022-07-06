<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MenuAddController extends AbstractController
{

    public function __invoke(Request $request, EntityManagerInterface $entityManager)
    {
        $content = $request->getContent();
         
    }
    // #[Route('/menu/add', name: 'app_menu_add')]
    // public function index(): JsonResponse
    // {
    //     return $this->json([
    //         'message' => 'Welcome to your new controller!',
    //         'path' => 'src/Controller/MenuAddController.php',
    //     ]);
    // }
}
