<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AvailabilityRepository; 
use App\Repository\CarRepository; 

use App\Form\ChooseDateandPriceType;

use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    #[Route("/", name:"home", methods: ['GET', 'POST'] )] 
    public function home(Request $request, AvailabilityRepository $repository, CarRepository $carRepository): Response
    {
        $dispos = $repository->findAll();
        $cars = $carRepository->findAll();
        
        $form = $this->createForm(ChooseDateandPriceType::class);
        $form->handleRequest($request);
        
        $startDate = null;
        $endDate = null;
        $maxPrice = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData(); 
            $startDate = $data->getStartDate();
            $endDate = $data->getEndDate();
            $maxPrice = $data->getPrice();

            
            $availabilities = $repository->findByDateRange($startDate, $endDate);

            
            return $this->render('home/index.html.twig', [
                'dispos' => $availabilities,
                'cars' => $cars,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'maxPrice' => $maxPrice, 
                'ChooseDateandPriceType' => $form->createView()
            ]);
        }

        return $this->render('home/index.html.twig', [
            'dispos' => $dispos,
            'cars' => $cars,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'maxPrice' => $maxPrice,
            'ChooseDateandPriceType' => $form->createView()
        ]);
    }


}



    // #[Route('/voiture', name: 'app_show_all_car')]
    // public function show(AvailabilityRepository $repository, CarRepository $carRepository ): Response
    // {
    //     $dispos = $repository->findAll();
    //     $cars = $carRepository->findAll();

    //     return $this->render('show_all_car/index.html.twig', [
    //         'controller_name' => 'ShowAllCarController',
    //         'dispos' => $dispos,
    //         'cars' => $cars
    //     ]);
    // }




