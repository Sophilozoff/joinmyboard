<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, [
                'label'=>false
            ])
            ->add('password', PasswordType::class, [
                'label'=>false
            ])
            ->add('email', null, [
                'label'=>false
            ])
            ->add('roles', ChoiceType::class, [
                'label'=>false,
                "choices"=>[
                    "Admin"=>"ROLE_ADMIN",
                    "User"=>"ROLE_USER"
                ],
                'expanded'=> true,
                'multiple'=> true,
                "choice_attr"=>function(){
                    return["type"=>"radio"];
                }
            ])
            ->add('sex', ChoiceType::class, [
                'label'=> false,
                "choices"=>[
                    "Féminin"=>"F",
                    "Masculin"=>"M",
                    "Non binaire"=>"NB"
                ],
                "multiple"=>false
            ])
            ->add('dateOfBirth', null, [
                'label'=>false
            ])
            ->add('avatarFile', VichImageType::class, [
                'label'=>false
            ])
            ->add('description', TextType::class, [
                'label'=>false
            ]);
            if($options['isAdmin']){
                $builder
                ->add('roles', ChoiceType::class, [
                    'label'=>false,
                    "choices"=>[
                        "Admin"=>"ROLE_ADMIN",
                        "Abonné"=>"ROLE_USER"
                    ],
                    "multiple"=>true,
                    "expanded"=>true,
                    "choice_attr"=>function(){
                        return["class"=>"form-check-input"];
                    }
                ]);
            };
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'isAdmin' => false
        ]);
    }
}
