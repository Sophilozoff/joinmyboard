<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use APP\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setUsername("admin")->setRoles(["ROLE_ADMIN"])->setPassword($this->encoder->encodePassword($admin, "mdp"))->setDateOfBirth("16/07/1987");
        
        $manager->persist($admin);
        $manager->flush();
    }
}
