<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTimeImmutable;

#[Route('/product/controller1')]
class ProductController1 extends AbstractController
{
    #[Route('/', name: 'app_product_controller1_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        // Get the security service
        $securityChecker = $this->container->get('security.authorization_checker');

        // Check if the user is authenticated
        if (!$securityChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            // If its not, redirect to 'required_loggin' page
            return $this->redirectToRoute('required_loggin');
        }      

        return $this->render('product_controller1/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_product_controller1_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Get the security service
        $securityChecker = $this->container->get('security.authorization_checker');

        // Check if the user is authenticated
        if (!$securityChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            // If its not, redirect to 'required_loggin' page
            return $this->redirectToRoute('required_loggin');
        }    
        
        $product = new Product();
        $product->setCreatedAt(new DateTimeImmutable());
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash('success','A new product has been created successfully!');

            return $this->redirectToRoute('app_product_controller1_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product_controller1/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_controller1_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        if(!$product){
            $this->addFlash('danger','Product not found!');
        }

        return $this->render('product_controller1/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/{Sku}/edit', name: 'app_product_controller1_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product = null, EntityManagerInterface $entityManager): Response
    {
        // Get the security service
        $securityChecker = $this->container->get('security.authorization_checker');

        // Check if the user is authenticated
        if (!$securityChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            // If its not, redirect to 'required_loggin' page
            return $this->redirectToRoute('required_loggin');
        }    

        if(!$product){
            $sku = $request->attributes->get('Sku'); // Obtener el SKU de la solicitud
            $this->addFlash('danger', sprintf('The product of SKU "%s" does not match with an existent product!', $sku));
            return $this->redirectToRoute('app_product_controller1_index');
        }

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setUpdateAt(new DateTimeImmutable());
            $entityManager->flush();

            $this->addFlash('success','A product has been edited successfully!');

            return $this->redirectToRoute('app_product_controller1_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product_controller1/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_controller1_delete', methods: ['POST'])]
    public function delete(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        // Get the security service
        $securityChecker = $this->container->get('security.authorization_checker');

        // Check if the user is authenticated
        if (!$securityChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            // If its not, redirect to 'required_loggin' page
            return $this->redirectToRoute('required_loggin');
        }    

        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_product_controller1_index', [], Response::HTTP_SEE_OTHER);
    }

}
