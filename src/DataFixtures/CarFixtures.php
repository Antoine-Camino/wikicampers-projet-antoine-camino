<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Car;

class CarFixtures extends Fixture
{
    public const CAR_REFERENCE_PREFIX = 'car_';

    public function load(ObjectManager $manager): void
    {
        $carsData = [
            ['model' => 'Clio', 'brand' => 'Renault'],
            ['model' => 'Golf', 'brand' => 'Volkswagen'],
            ['model' => 'Focus', 'brand' => 'Ford'],
            ['model' => 'Astra', 'brand' => 'Opel'],
            ['model' => '208', 'brand' => 'Peugeot'],
        ];

        foreach ($carsData as $index => $carData) {
            $car = new Car();
            $car->setModel($carData['model']);
            $car->setBrand($carData['brand']);
            
           
            $manager->persist($car);

          
            $referenceName = self::CAR_REFERENCE_PREFIX . $index;
            $this->addReference($referenceName, $car);
        }

        $manager->flush();
    }
}