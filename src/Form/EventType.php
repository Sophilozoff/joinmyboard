<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Bar;
use App\Entity\Boardgame;
use App\Repository\BarRepository;
use App\Repository\BoardgameRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class EventType extends AbstractType
{

    private $barRepository;

    public function __construct(BarRepository $barRepository, BoardgameRepository $boardgameRepository)
    {
        $this->barRepository = $barRepository;
        $this->boardgameRepository = $boardgameRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('title', null, [
                'label'=>false
            ])
            ->add('dateEvent', DateType::class, [
                'label'=>false,
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'dd-MM-yyyy',
                'attr' => ['class' => 'datepicker']])
                ->add('timeEvent', TimeType::class, [
                    'label'=>false,
                    'widget' => 'single_text',
                    'html5' => false,
                    'attr' => ['class' => 'timepicker']])
            ->add('nbMaxPlayers', ChoiceType::class, [
                'label'=>false,
                "choices"=>[
                    "2"=>"2",
                    "3"=>"3",
                    "4"=>"4",
                    "5"=>"5",
                    "6"=>"6",
                    "7"=>"7",
                    "8"=>"8",
                ],
                "multiple"=>false
            ])
            ->add('imageFile', VichImageType::class, [
                'label'=>false
            ])
            ->add('description', null, [
                'label'=>false
            ])
            ->add('location', EntityType::class, [
                'class' => Bar::class,
                'label'=>false,
                'choices' =>[$this->barRepository->findAll()],
                "multiple"=>false,
                ])
            ->add('pickedGames', EntityType::class, [
                'class' => Boardgame::class,
                'label'=>false,
                'choices' =>[$this->boardgameRepository->findAll()],
                "multiple"=>true
            ])
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
