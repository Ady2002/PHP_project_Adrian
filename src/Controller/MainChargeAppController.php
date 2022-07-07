<?php

namespace App\Controller;

use App\Entity\Locations;
use App\Entity\Stations;
use App\Form\FilterFormType;
use App\Repository\StationsRepository;
use App\Repository\LocationsRepository;
use ContainerE0P3VIB\getConsole_ErrorListenerService;
use ContainerUp8x9wi\getLocationsRepositoryService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainChargeAppController extends AbstractController
{
    #[Route('/',name:'homepage')]
   /* #[Route("/src/Entity/Locations/{id}")]*/

    public function homepage(Request $request,ManagerRegistry $doctrine): Response
    {
      $stations=[];
	  $title='';
      $form=$this->createForm(FilterFormType::class);
	  $form->handleRequest($request);
      if($form->isSubmitted()&&$form->isValid())
      {
		 $city_filter=$form->getData()['City'];
		 $charge_type_filter=$form->getData()['Type'];
		if($city_filter=='-1' || $charge_type_filter=='-1') {
			 return $this->render( 'chargeapp.twig', [
				 'message'  => 'both filters are required',
				 'title'    => 'all cities and stations',
				 'stations' => $doctrine->getRepository( Stations::class )->findAll(),
				 'form'     => $form->createView()
			 ] );
		 }
		 else
		 {
			 return $this->render( 'chargeapp.twig', [
				 'form'=>$form->createView(),
				 'title'    => 'Csda',
				 'message'=>'',
				 'stations' => $doctrine->getRepository( Stations::class )->filterStations($city_filter,$charge_type_filter)
			 ] );
		 }
      }
	  else {
		  $stations = $doctrine->getRepository( Stations::class )->findAll();
		  $title     = 'All stations';
	   }

	    return $this->render('chargeapp.twig', [
		    'form'=>$form->createView(),
		    'stations'=>$stations,
		    'title'=>$title,
		    'message'=>'Nonexistent'

	    ]);
	    // tell Doctrine you want to (eventually) save the Product (no queries yet)
	  //  $entityManager->persist($product);

	    // actually executes the queries (i.e. the INSERT query)
	  //  $entityManager->flush();




    }
}
