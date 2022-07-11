<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Car;
use App\Entity\Locations;
use App\Entity\Stations;
use App\Form\BookingFormType;
use App\Form\FilterFormType;
use App\Repository\StationsRepository;
use App\Repository\LocationsRepository;
use ContainerE0P3VIB\getConsole_ErrorListenerService;
use ContainerUp8x9wi\getLocationsRepositoryService;
use Symfony\Component\Security\Core\Security;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class MainChargeAppController extends AbstractController {


	#[Route( '/', name: 'homepage' )]
	/* #[Route("/src/Entity/Locations/{id}")]*/

	public function homepage(
		Request $request, ManagerRegistry $doctrine
	): Response {
		$stations = [];
		$title    = '';
		$form     = $this->createForm( FilterFormType::class );
		$form->handleRequest( $request );
		if ( $form->isSubmitted() && $form->isValid() ) {
			$city_filter        = $form->getData()['City'];
			$charge_type_filter = $form->getData()['Type'];
			if ( $city_filter == '-1' || $charge_type_filter == '-1' ) {
				return $this->render( 'chargeapp.twig', [
					'message'  => 'both filters are required',
					'title'    => 'all cities and stations',
					'stations' => $doctrine->getRepository( Stations::class )->findAll(),
					'form'     => $form->createView()
				] );
			} else {
				return $this->render( 'chargeapp.twig', [
					'form'     => $form->createView(),
					'title'    => 'Filtered Stations',
					'message'  => '',
					'stations' => $doctrine->getRepository( Stations::class )->filterStations( $city_filter, $charge_type_filter )
				] );
			}
		} else {
			$stations = $doctrine->getRepository( Stations::class )->findAll();
			$title    = 'All stations';
		}

		return $this->render( 'chargeapp.twig', [
			'form'     => $form->createView(),
			'stations' => $stations,
			'title'    => $title,
			'message'  => 'Nonexistent filter'

		] );
	}

	#[Route( '/profile', name: 'Profile', methods: [ 'GET' ] )]
	public function profiles( ManagerRegistry $doctrine ): Response {
		$user = $this->getUser();
		if ( ! $user ) {
			return $this->render( 'chargeapp.twig', [
				'form'      => $form = $this->createForm( FilterFormType::class )->createView(),
				'locations' => $doctrine->getRepository( Locations::class )->findAll(),
				'title'     => 'All locations',
				'message'   => 'you must be logged in to access profile page!'
			] );
		}

		return $this->render( 'profile.twig' );
	}

	#[Route( '/profile', name: 'cars', methods: [ 'POST' ] )]
	public function AddCarToProfile( ManagerRegistry $doctrine, Request $request ): Response {
		$user          = $this->getUser();
		$license_plate = $request->get( 'license' );
		$type          = $request->get( 'chrtype' );
		if ( $license_plate || $type == "er" ) {
			return $this->render( 'profile.twig', [
				'bookings' => $doctrine->getRepository( Booking::class )->getUserBookings( $user ),
				'message'  => 'please select a charging type and write a valid license plate'
			] );
		}
		$cars = $doctrine->getRepository( Car::class )->findAll();
		foreach ( $cars as $car ) {
			if ( $car->getLicensePlate() == $license_plate ) {
				return $this->render( 'profile.twig', [
					'bookings' => $doctrine->getRepository( Booking::class )->getUserBookings( $user ),
					'message'  => 'This license plate has already been registered'
				] );
			}
		}
		$car = new Car();
		$car->setLicensePlate( $license_plate );
		$car->setChargeType( $type );
		$car->setUserID( $user );
		$doctrine->getManagers()->persist( $car );
		$doctrine->getManagers()->flush();

		return $this->redirectToRoute( 'profile' );
	}

	#[Route( "/station/{id}", name: "station" )]
	public function station( Request $request, ManagerRegistry $doctrine, $id ): Response {
		$station = $doctrine->getRepository( Stations::class )->findOneBy( array( 'id' => $id ) );
		$form    = $this->createForm( BookingFormType::class );
		$form->handleRequest( $request );
		$bookings = $doctrine->getRepository( Booking::class )->getActiveBookings( $id );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$start = $form->getData()['start'];
			$end   = $form->getData()['end'];
			$car   = $doctrine->getRepository( Car::class )->findOneBy( array( 'license_plate' => $form->getData()['car'] ) );
			if ( $car == null ) {
				return $this->render( 'station.html.twig', [
					'station' => $station,
					'form' => $form->createView(),
					'bookings' => $bookings,
					'message' => 'You must select a car to make your reservation.',
				] );
		   }
			if($start<new \DateTimeImmutable())
			{
				return $this->render('station.html.twig', [
					'station' => $station,
					'form' => $form->createView(),
					'bookings' => $bookings,
					'message' => 'Booking must not be made in the past.']);
			}
		}
		if($car->getChargeType()!=$station->getStationType()){
			return $this->render('station.html.twig', [
				'station' => $station,
				'form' => $form->createView(),
				'bookings' => $bookings,
				'message' => 'This car has a different charging type from the station. Please select a different station or a car with charging ' . $station->getStationType(),
				]);
		}
		$booking= new Booking();
		$booking->setChargeStart($start);
		$booking->setChargeEnd($end);
		$booking->setStationID($station);
		$booking->setCarID($car);

		$doctrine->getManager()->persist($booking);
		$doctrine->getManager()->flush();
		return $this->render('station.html.twig', [
			'station' => $station,
			'form' => $form->createView(),
			'bookings' => $bookings,
			'message' => 'Nonexistent'
		]);
	}
	/*#[Route('/booking',name:'Bookings')]
	public function booking(Request $request,ManagerRegistry $doctrine):Response{
		$booking=new Booking();
		$book_form=new BookingFormType();
		$entity_manager=$doctrine->getManager();
		$form=$this->createForm(BookingFormType::class,$book_form);
		$form->handleRequest($request);
		if($form->isSubmitted()&&$form->isValid())
		{
			return new Response('das');
		}
		return new Response('das');
	}*/
}
