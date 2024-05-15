<?php

namespace App\Form;

use App\Entity\Availability;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AddAvailabilityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Price')
            ->add('StartDate')
            ->add('endDate')
            ->add('available')
            ->add('LinkCar', EntityType::class, [
                'class' => 'App\Entity\Car',
                'choice_label' => function ($car) {
                    return $car->getBrand() . ' ' . $car->getModel();
                },
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
                'choice_attr' => function ($choiceValue, $key, $value) {
                    return ['class' => 'car_checkbox'];
                },
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Submit',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Availability::class,
        ]);
    }
}


