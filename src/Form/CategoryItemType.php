<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\CategoryCollection;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\CollectionType as CustomCollectionType;


class CategoryItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',  null, [
                'label' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter collection name',
                    ]),
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => false,
            ])
            ->add('itemAttributeStringFields', CustomCollectionType::class, [
                'entry_type' => AitemAttributeStringFieldType::class,
                'entry_options' => ['label' => false],
                'label' => false,
                'by_reference' => false,
            ])
            ->add('itemAttributeBooleanFields', CustomCollectionType::class, [
                'entry_type' => ItemAttributeBooleanFieldRepositoryType::class,
                'entry_options' => ['label' => false],
                'label' => false,
                'by_reference' => false,
            ])
            ->add('itemAttributeDateFields', CustomCollectionType::class, [
                'entry_type' => ItemAttributeDateType::class,
                'entry_options' => ['label' => false],
                'label' => false,
                'by_reference' => false,
            ])
            ->add('itemAttributeIntegerFields', CustomCollectionType::class, [
                'entry_type' => ItemAttributeIntegerType::class,
                'entry_options' => ['label' => false],
                'label' => false,
                'by_reference' => false,
            ])
            ->add('itemAttributeTextFields', CustomCollectionType::class, [
                'entry_type' => ItemAttributeTextType::class,
                'entry_options' => ['label' => false],
                'label' => false,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CategoryCollection::class,
        ]);
    }
}
