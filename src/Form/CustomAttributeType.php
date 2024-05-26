<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\CustomAttribute;
use App\Enum\CustomAttributeType as CustomAttributeEnum;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class CustomAttributeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter attribute name',
                    ]),
                    new Length([
                        'min' => 3,
                        'max' => 30,
                        'minMessage' => 'Your attribute name should be at least {{ limit }} characters',
                        'maxMessage' => 'Your attribute name should be at most {{ limit }} characters',
                    ]),
                ],
            ])
            ->add('type', EnumType::class, [
                'class' => CustomAttributeEnum::class,
                // 'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CustomAttribute::class,
        ]);
    }
}
