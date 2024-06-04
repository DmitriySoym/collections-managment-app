<?php

namespace App\Form;

use App\Entity\CategoryCollection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\CollectionType as CustomCollectionType;
use Symfony\Contracts\Translation\TranslatorInterface;


class CategoryItemType extends AbstractType
{
    public function __construct(
        private TranslatorInterface $translator
    ) {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $translatedDescription = $this->translator->trans('createCollectionItem.enterItemDescription');
        $translatedName = $this->translator->trans('createCollectionItem.enterItemName');
        $translatedDescriptionLimit = $this->translator->trans('createCollectionItem.descriptionLimit', [
            '%limit%' => 10
        ]);
        $builder
            ->add('name',  null, [
                'label' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => $translatedName,
                    ]),
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => $translatedDescription,
                    ]),
                    new Length([
                        'min' => 10,
                        'minMessage' =>  $translatedDescriptionLimit,
                        'max' => 255,
                    ]),
                ],
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
