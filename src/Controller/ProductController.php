<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    // #[Route('/product', name: 'app_product')]
    // public function index(): Response
    // {
    //     // Obtén el servicio de seguridad
    //     $securityChecker = $this->container->get('security.authorization_checker');

    //     // Verifica si el usuario está autenticado
    //     if (!$securityChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
    //         // Si no está autenticado, redirige a la página de "Necesitas logear"
    //         return $this->redirectToRoute('required_loggin');
    //     }

    //     return $this->render('product/index.html.twig', [
    //         'controller_name' => 'ProductController',
    //     ]);
    // }
}
