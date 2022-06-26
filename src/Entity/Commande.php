<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ApiResource]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'boolean')]
    private $etatCommande;

    #[ORM\Column(type: 'integer')]
    private $numeroCommande;

    #[ORM\Column(type: 'datetime')]
    private $dateCommande;

    #[ORM\Column(type: 'boolean')]
    private $etatPaiement;

    #[ORM\Column(type: 'boolean')]
    private $statutCommande;

    #[ORM\Column(type: 'integer')]
    private $paiement;

    #[ORM\Column(type: 'integer')]
    private $numeroTicket;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isEtatCommande(): ?bool
    {
        return $this->etatCommande;
    }

    public function setEtatCommande(bool $etatCommande): self
    {
        $this->etatCommande = $etatCommande;

        return $this;
    }

    public function getNumeroCommande(): ?int
    {
        return $this->numeroCommande;
    }

    public function setNumeroCommande(int $numeroCommande): self
    {
        $this->numeroCommande = $numeroCommande;

        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(\DateTimeInterface $dateCommande): self
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }

    public function isEtatPaiement(): ?bool
    {
        return $this->etatPaiement;
    }

    public function setEtatPaiement(bool $etatPaiement): self
    {
        $this->etatPaiement = $etatPaiement;

        return $this;
    }

    public function isStatutCommande(): ?bool
    {
        return $this->statutCommande;
    }

    public function setStatutCommande(bool $statutCommande): self
    {
        $this->statutCommande = $statutCommande;

        return $this;
    }

    public function getPaiement(): ?int
    {
        return $this->paiement;
    }

    public function setPaiement(int $paiement): self
    {
        $this->paiement = $paiement;

        return $this;
    }

    public function getNumeroTicket(): ?int
    {
        return $this->numeroTicket;
    }

    public function setNumeroTicket(int $numeroTicket): self
    {
        $this->numeroTicket = $numeroTicket;

        return $this;
    }
}
