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

$gestionaire->setEmail("adama@gmail.com");
$gestionaire->setPrenom("adame");
$gestionaire->setNom("sene");
$gestionaire->setPassword("sene");
$gestionaire->setEtat("1");
$gestionaire->setTelephone(776890099);

$gestionaire->setPassword($this->passwordhas->hashPassword($gestionaire, "sene"));
$manager->persist($gestionaire);
        $manager->flush();

    }
}
