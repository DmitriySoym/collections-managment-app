<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\CategoryType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType; //правильный тип данных
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Contracts\Translation\TranslatorInterface;

class CollectionCreateType extends AbstractType
{
        public function __construct(
        private TranslatorInterface $translator
    ) {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $translatedType = $this->translator->trans('createCollection.catygoryType');
        $translatedName = $this->translator->trans('createCollection.collectionName');
        $translatedDescription = $this->translator->trans('collection.collectionDescription');
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' =>  $translatedName,
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter collection name',
                    ]),
                    new Length([
                        'min' => 3,
                        'max' => 30,
                        'minMessage' => 'Your collection name should be at least {{ limit }} characters',
                        'maxMessage' => 'Your collection name should be at most {{ limit }} characters',
                    ]),
                ],
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'placeholder' =>  $translatedDescription,
                ],
                'label' => false,
                
            ])
            // ->add('imageUrl')
            // ->add('updated', null, [
            //     'widget' => 'single_text'
            // ])
            ->add('catygoryType', EntityType::class, [
                'class' => CategoryType::class,
                'label' => $translatedType,
                'choice_label' => 'name',
            ])
            ->add('customAttributes', CollectionType::class, [
                'entry_type' => CustomAttributeType::class,
                'entry_options' => ['label' => false],
                'label' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
