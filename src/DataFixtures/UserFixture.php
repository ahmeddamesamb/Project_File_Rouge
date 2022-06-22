<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
 
private $passwordhas;
public function __construct(UserPasswordHasherInterface $passwordhas)
{
$this->passwordhas = $passwordhas;
}

public function load(ObjectManager $manager):void
{
$user = new User();

$user->setEmail("Rawane@gmail.com");
$user->setPrenom("Rawane");
$user->setNom("sarr");
$user->setPassword("sarr");
$user->setEtat("1");
$user->setRoles(["ROLE_Gestionaire"]);
$user->setPassword($this->passwordhas->hashPassword($user, "sarr"));
$manager->persist($user);
        $manager->flush();

    }
}
