<?php

namespace App\Form;

use App\Entity\Car;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Availability;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AddCarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Brand', null, [
                'label' => 'Marque', 
            ])
            ->add('Model', null, [
                'label' => 'Modèle', 
            ])
            // ->add('availabilities', EntityType::class, [
            //     'class' => Availability::class,
            //     'choice_label' => function (Availability $availability) {
            //         return sprintf(
            //             'Start Date: %s - End Date: %s',
            //             $availability->getStartDate()->format('d-m-Y'),
            //             $availability->getEndDate()->format('d-m-Y')
            //         );
            //     },
            //     'multiple' => true,
            //     'expanded' => true, 
            // ])
            ->add('save', SubmitType::class, [
                'label' => 'Ajouter',
                'attr' => ['class' => 'btn btn-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}





