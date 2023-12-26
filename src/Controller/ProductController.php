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

#[Route('/product')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'app_product_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        // Get the security service
        $securityChecker = $this->container->get('security.authorization_checker');

        // Check if the user is authenticated
        if (!$securityChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            // If its not, redirect to 'required_loggin' page
            return $this->redirectToRoute('required_loggin');
        }      

        return $this->render('product_crud/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_product_new', methods: ['GET', 'POST'])]
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

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product_crud/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{Sku}', name: 'app_product_show', methods: ['GET'])]
    public function show(Product $product = null): Response
    {
        // Get the security service
        $securityChecker = $this->container->get('security.authorization_checker');

        // Check if the user is authenticated
        if (!$securityChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            // If its not, redirect to 'required_loggin' page
            return $this->redirectToRoute('required_loggin');
        } 

        // Check if the injected ID value passed throughx the URL corresponds to an existing product
        if(!$product){
            $this->addFlash('danger','Product not found!');
            return $this->redirectToRoute('app_product_index');
        }

        return $this->render('product_crud/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/{Sku}/edit', name: 'app_product_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product = null, EntityManagerInterface $entityManager): Response
    {
        // Get the security service
        $securityChecker = $this->container->get('security.authorization_checker');

        // Check if the user is authenticated
        if (!$securityChecker->isGranted('IS_AUTHENTICATED_FULLY')) {
            // If its not, redirect to 'required_loggin' page
            return $this->redirectToRoute('required_loggin');
        }    

        // Check if the injected Sku value passed through the URL corresponds to an existing product
        if(!$product){
            $sku = $request->attributes->get('Sku'); // Obtener el SKU de la solicitud
            $this->addFlash('danger', sprintf('The product of SKU "%s" does not match with an existent product!', $sku));
            return $this->redirectToRoute('app_product_index');
        }

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setUpdateAt(new DateTimeImmutable());
            $entityManager->flush();

            $this->addFlash('success','A product has been edited successfully!');

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('product_crud/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_delete', methods: ['POST'])]
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

        $this->addFlash('success','A product has been deleted successfully!');
        return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
    }

}
