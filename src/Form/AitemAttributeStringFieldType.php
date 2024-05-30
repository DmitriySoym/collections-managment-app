<?php

namespace App\Form;

use App\Entity\CategoryCollection;
use App\Entity\CustomAttribute;
use App\Entity\ItemAttributeStringField;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AitemAttributeStringFieldType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $customItemAttributeName = $event->getData()->getCustomItemAttribute()->getName();
            $form = $event->getForm();
            $form
            ->add('value', TextType::class, [
                    'label' => $customItemAttributeName,
            ]);
        });
            // ->add('value')
            // ->add('item', EntityType::class, [
            //     'class' => CategoryCollection::class,
            //     'choice_label' => 'id',
            // ])
            // ->add('customItemAttribute', EntityType::class, [
            //     'class' => CustomAttribute::class,
            //     'choice_label' => 'id',
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ItemAttributeStringField::class,
        ]);
    }
}
