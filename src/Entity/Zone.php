<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ZoneRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ZoneRepository::class)]
#[ApiResource]
class Zone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nomZone;

    #[ORM\Column(type: 'integer')]
    private $coutLivraison;

    #[ORM\Column(type: 'boolean')]
    private $etatZone;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomZone(): ?string
    {
        return $this->nomZone;
    }

    public function setNomZone(string $nomZone): self
    {
        $this->nomZone = $nomZone;

        return $this;
    }

    public function getCoutLivraison(): ?int
    {
        return $this->coutLivraison;
    }

    public function setCoutLivraison(int $coutLivraison): self
    {
        $this->coutLivraison = $coutLivraison;

        return $this;
    }

    public function isEtatZone(): ?bool
    {
        return $this->etatZone;
    }

    public function setEtatZone(bool $etatZone): self
    {
        $this->etatZone = $etatZone;

        return $this;
    }
}
