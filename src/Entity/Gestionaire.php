<?php

namespace App\Entity;

use App\Repository\GestionaireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GestionaireRepository::class)]
class Gestionaire extends User
{

}
