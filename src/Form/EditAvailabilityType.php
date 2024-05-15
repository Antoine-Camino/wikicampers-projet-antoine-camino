<?php

namespace App\Form;

use App\Entity\Availability;
use App\Entity\Car;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EditAvailabilityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Price')
            ->add('StartDate')
            ->add('endDate')
            ->add('available')
            ->add('LinkCar', EntityType::class, [
                'class' => Car::class,
                'choice_label' => function (Car $car) {
                    return $car->getBrand() . ' ' . $car->getModel();
                },
                'multiple' => true,
                'expanded' => true, // Pour afficher des cases à cocher
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => ['class' => 'btn btn-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Availability::class,
        ]);
    }
}


