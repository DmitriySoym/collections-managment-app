<?php

namespace App\Form;

use App\Entity\CategoryCollection;
use App\Entity\CustomItemAttribute;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CustomAttributeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('value', null, [
                'label' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter value',
                    ]),
                    new Length([
                        'max' => 255,
                    ]),
                ],
            ])
            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'Integer' => 'Integer',
                    'String' => 'String',
                    'Text' => 'Text',
                    'Boolean' => 'Boolean',
                    'Date' => 'Date',
                ],
            ])
            // ->add('categoryCollection', EntityType::class, [
            //     'class' => CategoryCollection::class,
            //     'choice_label' => 'id',
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CustomItemAttribute::class,
        ]);
    }
}
