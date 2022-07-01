<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StationsAndLocations extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
	    for($i=0;$i<15;$i++)
	    {
		    $location=new \App\Entity\Locations();
		    $location->setLat(45.8+rand(-1,1));
		    $location->setLongitude(24.9+rand(-1,1));
		    $location->setTotalSpots($i*2+1);
		    $location->setName('Carefour'.$i);
		    $location->setPrice($i*3+rand(0,5));

		    $station=new \App\Entity\Stations();
		    if($i%2==0)
			    $station->setStationType('type 2');
		    else
			    $station->setStationType('type 1');
		    $station->setPower($i+3);
		    $station->setLocationID($location);

		    $manager->persist($location);
		    $manager->persist($station);
	    }

        $manager->flush();
    }
}
