<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\GestionaireRepository;
use ApiPlatform\Core\Annotation\ApiResource;
#[ApiResource()]
#[ORM\Entity(repositoryClass: GestionaireRepository::class)]
class Gestionaire extends User
{

    public function __construct()
    {

    }

    }

