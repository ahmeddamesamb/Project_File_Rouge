<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\GestionaireRepository;
use ApiPlatform\Core\Annotation\ApiResource;
#[ApiResource()]
#[ORM\Entity(repositoryClass: GestionaireRepository::class)]
class Gestionaire extends User
{

}
