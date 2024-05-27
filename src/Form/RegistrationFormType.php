<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use  Symfony\Component\Validator\Constraints\Email;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationFormType extends AbstractType
{

    public function __construct(
        private TranslatorInterface $translator
    ) {}
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $agreeTerms = $this->translator->trans('register.agreeTerms');
        $agreeTermsWarning = $this->translator->trans('register.shouldAgreeTerms');
        $translatedWarning = $this->translator->trans('register.enterCorrectEmail');
        $translatedEnterPassword = $this->translator->trans('register.enterPassword');

        $transPassLength = $this->translator->trans('register.passwordMinLength');

        $builder
            ->add('username', null, [
                'label' => false,
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Email([
                        'message' => $translatedWarning,
                    ])
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => $agreeTerms,
                'constraints' => [
                    new IsTrue([
                        'message' => $agreeTermsWarning,
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'label' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => $translatedEnterPassword,
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => $transPassLength,
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
