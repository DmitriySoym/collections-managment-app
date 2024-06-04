<?php

namespace App\Form;

use App\Entity\CategoryCollection;
use App\Entity\CustomAttribute;
use App\Entity\ItemAttributeIntegerField;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Contracts\Translation\TranslatorInterface;

class ItemAttributeIntegerType extends AbstractType
{
    public function __construct(
        private TranslatorInterface $translator
    ) {}
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $customItemAttributeName = $event->getData()->getCustomItemAttribute()->getName();
            $form = $event->getForm();
            $form
                ->add('value', IntegerType::class, [
                    'label' => $customItemAttributeName,
                    'constraints' => [
                    new NotBlank([
                            'message' => $this->translator->trans('createCollectionItem.fillThisField'),
                        ]),
                    ],
                ]);
        })
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ItemAttributeIntegerField::class,
        ]);
    }
}
