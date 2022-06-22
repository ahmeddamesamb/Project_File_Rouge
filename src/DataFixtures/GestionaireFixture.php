<?php

namespace App\DataFixtures;

use App\Entity\Gestionaire;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class GestionaireFixture extends Fixture
{
  
private $passwordhas;
public function __construct(UserPasswordHasherInterface $passwordhas)
{
$this->passwordhas = $passwordhas;
}

public function load(ObjectManager $manager):void
{
$gestionaire = new Gestionaire();

$gestionaire->setEmail("Mouhamed@gmail.com");
$gestionaire->setPrenom("Mouhamed");
$gestionaire->setNom("Samb");
$gestionaire->setPassword("Samb");
$gestionaire->setEtat("1");
$gestionaire->setRoles(["ROLE_Gestionaire"]);
$gestionaire->setPassword($this->passwordhas->hashPassword($gestionaire, "Samb"));
$manager->persist($gestionaire);
        $manager->flush();
    }
}
