<?php

namespace App\Form;

use App\Entity\Boardgame;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Vich\UploaderBundle\Form\Type\VichImageType;


class BoardgameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label' => false
            ])
            ->add('image', null, [
                'label'=>false,
            ])
            ->add('nbPlayersMin', ChoiceType::class, [
                'label'=>false,
                "choices"=>[
                    "1"=>"1",
                    "2"=>"2",
                    "3"=>"3",
                    "4"=>"4",
                    "5"=>"5",
                    "6"=>"6",
                    "7"=>"7",
                ],
                "multiple"=>false
            ])
            ->add('nbPlayersMax', ChoiceType::class, [
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
            ->add('description', null, [
                'label'=>false,

            ])
            ->add('playingTime', null, [
                'label'=>false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Boardgame::class,
        ]);
    }
}
