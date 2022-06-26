<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LivraisonRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
#[ApiResource]
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $telephoneLivraison;

    #[ORM\Column(type: 'boolean')]
    private $etatLivraison;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTelephoneLivraison(): ?int
    {
        return $this->telephoneLivraison;
    }

    public function setTelephoneLivraison(int $telephoneLivraison): self
    {
        $this->telephoneLivraison = $telephoneLivraison;

        return $this;
    }

    public function isEtatLivraison(): ?bool
    {
        return $this->etatLivraison;
    }

    public function setEtatLivraison(bool $etatLivraison): self
    {
        $this->etatLivraison = $etatLivraison;

        return $this;
    }

  
}
