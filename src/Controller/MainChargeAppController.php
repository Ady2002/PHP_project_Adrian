<?php

namespace App\Controller;

use App\Entity\Locations;
use App\Form\FilterFormType;
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
		$locations=[];
		$title='';
      $form=$this->createForm(FilterFormType::class);
	  $form->handleRequest($request);
      if(($form->isSubmitted()))
      {
		 $city_filter=$form->getData('cities');
		 if($city_filter='-1') {
			 return $this->render( 'chargeapp.twig', [
				 'message'  => 'filters for both fields are required',
				 'title'    => 'all cities and stations',
				 'locations' => $doctrine->getRepository( Locations::class )->findAll(),
				 'form'     => $form->createView()
			 ] );
		 }
      }
	  else {
		  $locations = $doctrine->getRepository( Locations::class )->findAll();
		  $title     = 'All locations';
	  }

	    return $this->render('chargeapp.twig', [
		    'form'=>$form->createView(),
		    'locations'=>$locations,
		    'title'=>$title,
		    'message'=>'Nonexistent'

	    ]);
	    // tell Doctrine you want to (eventually) save the Product (no queries yet)
	  //  $entityManager->persist($product);

	    // actually executes the queries (i.e. the INSERT query)
	  //  $entityManager->flush();




    }
}
