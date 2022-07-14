<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\QuartierRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: QuartierRepository::class)]
#[ApiResource()]
class Quartier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]

    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    // #[Groups(["write",'quartier:read:simple'])]
    private $nomQuartier;


    #[ORM\Column(type: 'boolean')]
    private $etatQuartier=0;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'quartiers')]
    // #[Groups(["write",'quartier:read:simple'])]

    private $zone;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomQuartier(): ?string
    {
        return $this->nomQuartier;
    }

    public function setNomQuartier(string $nomQuartier): self
    {
        $this->nomQuartier = $nomQuartier;

        return $this;
    }

    public function isEtatQuartier(): ?bool
    {
        return $this->etatQuartier;
    }

    public function setEtatQuartier(bool $etatQuartier): self
    {
        $this->etatQuartier = $etatQuartier;

        return $this;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

}
