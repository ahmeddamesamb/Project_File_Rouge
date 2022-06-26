<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;
use ApiPlatform\Core\Annotation\ApiResource;

#[ApiResource()]
#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client  extends User
{
   
    #[ORM\Column(type: 'string', length: 255)]
    private $adresse;



    public function __construct()
    {
     
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

   
}
