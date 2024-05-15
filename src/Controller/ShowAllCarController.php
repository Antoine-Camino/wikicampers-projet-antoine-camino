<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


use App\Repository\AvailabilityRepository; 
use App\Repository\CarRepository; 
use App\Entity\Availability;
use App\Entity\Car;


use App\Form\EditAvailabilityType;
use App\Form\AddCarType;
use App\Form\AddAvailabilityType;


use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class ShowAllCarController extends AbstractController
{

    //afficher toute les dispo
    #[Route('/voiture', name: 'app_show_all_car')]
    public function show(AvailabilityRepository $repository, CarRepository $carRepository ): Response
    {

        
        $dispos = $repository->findAll();
        $cars = $carRepository->findAll();

        return $this->render('show_all_car/index.html.twig', [
            'controller_name' => 'ShowAllCarController',
            'dispos' => $dispos,
            'cars' => $cars
        ]);
    }


     //ajout de la route edit disponibilité------------
     #[Route('/create/{id}/edit', name: 'car.edit', methods:['GET','POST'])]
     public function edit(Request $request, $id, AvailabilityRepository $availabilityRepository, EntityManagerInterface $em): Response
     {
         $dispo = $availabilityRepository->find($id);
     
         $form = $this->createForm(EditAvailabilityType::class, $dispo);
         $form->handleRequest($request);
         
         if ($form->isSubmitted() && $form->isValid()) {
             $em->flush();
             return $this->redirectToRoute('app_show_all_car');
         }
     
         return $this->render('show_all_car/edit.html.twig', [
             'dispo' => $dispo,
             'form' => $form->createView()
         ]);
     }



     //ajout de la route creation voiture------------
    #[Route('/create/add', name: 'car.add')]
    public function create(Request $request, CarRepository $carRepository, EntityManagerInterface $em)
    {
        $car = new Car(); 
        $form = $this->createForm(AddCarType::class, $car);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($car);
            $em->flush();
            return $this->redirectToRoute('app_show_all_car');
        }

        return $this->render('show_all_car/addCar.html.twig', [
            'car' => $car, 
            'form' => $form->createView()
        ]);
    }

    //ajout de la route creation disponibilité------------
    #[Route('/create/addavailability', name: 'availability.add')]
    public function createAvailability(Request $request, AvailabilityRepository $availabilityRepository, CarRepository $carRepository, EntityManagerInterface $em)
    {
        $availability = new Availability(); 
        $form = $this->createForm(AddAvailabilityType::class, $availability);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($availability);
            $em->flush();
            return $this->redirectToRoute('app_show_all_car');
        }

        return $this->render('show_all_car/addAvailability.html.twig', [
            'availability' => $availability, 
            'form' => $form->createView()
        ]);
    }

    //ajout de la route de supression disponibilité------------
    #[Route('/create/{id}', name:'availability.delete', methods:['POST'])]
    public function remove(Request $request, $id ,AvailabilityRepository $availabilityRepository, CarRepository $carRepository, EntityManagerInterface $em){
        $dispo = $availabilityRepository->find($id);
        $em->remove($dispo);
        $em->flush();
        
        return $this->redirectToRoute('app_show_all_car');

    }



}
