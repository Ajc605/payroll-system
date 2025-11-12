<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

final class PayrollCalculatorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $currentYear = (int) date('Y');
        $years = range($currentYear - 1, $currentYear + 5);

        $builder
            ->add('month', ChoiceType::class, [
                'label' => 'Month',
                'choices' => [
                    'January' => 1,
                    'February' => 2,
                    'March' => 3,
                    'April' => 4,
                    'May' => 5,
                    'June' => 6,
                    'July' => 7,
                    'August' => 8,
                    'September' => 9,
                    'October' => 10,
                    'November' => 11,
                    'December' => 12,
                ],
                'placeholder' => 'Select a month',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Range(['min' => 1, 'max' => 12]),
                ],
                'attr' => [
                    'class' => 'form-select'
                ]
            ])
            ->add('year', ChoiceType::class, [
                'label' => 'Year',
                'choices' => array_combine($years, $years),
                'placeholder' => 'Select a year',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Range(['min' => 2000, 'max' => 2100]),
                ],
                'attr' => [
                    'class' => 'form-select'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => true,
        ]);
    }
}
