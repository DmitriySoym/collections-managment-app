<?php

namespace App\Form;

use App\Entity\ItemAttributeTextField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Contracts\Translation\TranslatorInterface;

class ItemAttributeTextType extends AbstractType
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
                ->add('value', TextareaType::class, [
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
            'data_class' => ItemAttributeTextField::class,
        ]);
    }
}
