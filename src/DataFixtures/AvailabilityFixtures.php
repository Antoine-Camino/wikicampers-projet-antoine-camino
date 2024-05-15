<?php

namespace App\DataFixtures;

use App\Entity\Availability;
use App\Entity\Car;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AvailabilityFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {


       
        for ($i = 0; $i < 10; $i++) {


            $price =  $price = mt_rand(20, 150); 

            
            $startDate = new \DateTime();
            $startDate->setTimestamp(mt_rand(strtotime('2024-05-01'), strtotime('2025-01-01')));

            
            $endDate = (clone $startDate)->modify('+1 day');

           
            $endDate->setTimestamp(mt_rand($endDate->getTimestamp(), strtotime('2025-01-01')));

            $currentDate = new \DateTime();
            $available = $currentDate < $startDate || $currentDate > $endDate;


            $availability = new Availability();
            $availability->setPrice($price);
            $availability->setStartDate($startDate);
            $availability->setEndDate($endDate);
            $availability->setAvailable(true); 

           
            $cars = $manager->getRepository(Car::class)->findAll();
            shuffle($cars); 
            $randomCars = array_slice($cars, 0, mt_rand(1, count($cars)));
            foreach ($randomCars as $car) {
                $availability->addLinkCar($car);
            }

            $manager->persist($availability);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [CarFixtures::class];
    }
}
