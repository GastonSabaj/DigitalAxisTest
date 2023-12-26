<?php

namespace App\Form;

use App\Entity\Product;
use App\Service\DoctrineMetadataService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class ProductType extends AbstractType
{
    private DoctrineMetadataService $doctrineMetadataService;

    public function __construct(DoctrineMetadataService $doctrineMetadataService)
    {
        $this->doctrineMetadataService = $doctrineMetadataService;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //Get the length defined in the database for each field 
        $skuMaxLength = $this->doctrineMetadataService->getFieldMaxLength(Product::class, 'Sku');
        $productNameMaxLength = $this->doctrineMetadataService->getFieldMaxLength(Product::class, 'product_name');
        $descriptionMaxLength = $this->doctrineMetadataService->getFieldMaxLength(Product::class, 'description');

        $builder
            ->add('Sku', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'maxlength' => $skuMaxLength, //Set the maxlength property for frontend
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[A-Za-z]+$/',
                        'message' => 'Sku field must be a string.',
                    ]),
                    new Length([
                        'min' => 1,
                        'max' => $skuMaxLength,
                    ]),
                ],
            ])
            ->add('product_name', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'maxlength' => $productNameMaxLength,
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[A-Za-z]+$/',
                        'message' => 'Product name must be a string.',
                    ]),
                    new Length([
                        'min' => 1,
                        'max' => $productNameMaxLength,
                    ]),
                ],
            ])
            ->add('description', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'maxlength' => $descriptionMaxLength,
                ],
                'constraints' => [
                    new Length([
                        'min' => 1,
                        'max' => $descriptionMaxLength,
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}