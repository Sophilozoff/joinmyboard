<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class EventType extends AbstractType
{
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
                'format' => 'dd-mm-yyyy',
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
