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
            // ->add('customItemAttributes', CollectionType::class, [
            //     'entry_type' => CustomAttributeType::class,
            //     'entry_options' => ['label' => false],
            //     'allow_add' => true,
            //     'allow_delete' => true,
            //     'by_reference' => false,
            //     'label' => false,
            // ])
            // ->add('created', null, [
            //     'widget' => 'single_text'
            // ])
            // ->add('updated', null, [
            //     'widget' => 'single_text'
            // ])
            // ->add('categotyId', EntityType::class, [
            //     'class' => Category::class,
            //     'choice_label' => 'id',
            // ])
            // ->add('userId', EntityType::class, [
            //     'class' => User::class,
            //     // 'choice_label' => 'id',
            //     'choice_label' => 'username',
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CategoryCollection::class,
        ]);
    }
}
