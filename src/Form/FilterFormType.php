<?php

namespace App\Form;

use App\Entity\Locations;
use App\Entity\Stations;
use App\Repository\LocationsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class FilterFormType extends AbstractType
{
	public EntityManagerInterface $enManager;
	public function __construct(EntityManagerInterface $entity_manager)
	{
		$this->enManager=$entity_manager;
	}

	public function buildForm( FormBuilderInterface $builder, array $options ):void
	{

	  $builder -> add('City', ChoiceType::class,[
		 'choice_loader'=>new CallbackChoiceLoader(function(){
			 {
				 $city_array=$this->enManager->getRepository(Locations::class)->findCities();
				 $cities=['Select city'=>'-1'];
				 foreach ($city_array as $city)
				 {
					 $cities[$city['City']]=$city['City'];
				 }
                 return $cities;
			 }
		 }),
	  ])

		/*  ->add('Type',ChoiceType::class,[
			  'choice_loader'=>new CallbackChoiceLoader(function(){
			  $types=['Select type'=>'-1','type 1'=>'type 1','type 2'=>'type 2'];
		      return $types;
			  })])
         */
		  ->add('Type',ChoiceType::class,['choice_loader'=>new CallbackChoiceLoader(function(){
			{
				 $stat_array=$this->enManager->getRepository(Stations::class)->findStations();
				 $cities=['Select type'=>'-1'];
				 foreach ($stat_array as $type)
				 {
					 $cities[$type['Station_Type']]=$type['Station_Type'];
				 }
                 return $cities;
			}
		}),

		])
		  ->add('filter',SubmitType::class);

	}
	public function configureOptions( OptionsResolver $resolver ):void {
		$resolver->setDefaults([]);
	}

}