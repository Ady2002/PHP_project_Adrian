<?php

namespace App\Controller;

use App\Entity\Locations;
use App\Repository\LocationsRepository;
use ContainerUp8x9wi\getLocationsRepositoryService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainChargeAppController extends AbstractController
{
    #[Route('/')]
   /* #[Route("/src/Entity/Locations/{id}")]*/

    public function show(ManagerRegistry $doctrine,LocationsRepository $locations_repository): Response
    {




        return $this->render('chargeapp.twig',['title'=>'Cities:','cities' => $locations_repository->findCities()]);
	    // tell Doctrine you want to (eventually) save the Product (no queries yet)
	  //  $entityManager->persist($product);

	    // actually executes the queries (i.e. the INSERT query)
	  //  $entityManager->flush();




    }
}
