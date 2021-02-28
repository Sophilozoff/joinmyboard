<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Bar;
use App\Entity\User;
use App\Repository\BarRepository;
use Symfony\Component\Security\Core\Security;
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

    private $security;
    public function __construct(BarRepository $barRepository, Security $security)
    {
        $this->barRepository = $barRepository;
        $this->security = $security;
        $user = $this->security->getUser();
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
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
