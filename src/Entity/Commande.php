<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\ManyToOne(targetEntity: Gestionaire::class, inversedBy: 'commandes')]
    private $gestionaire;

    #[ORM\ManyToOne(targetEntity: Livraison::class, inversedBy: 'commandes')]
    private $livraison;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes')]
    private $client;

    #[ORM\ManyToMany(targetEntity: Produit::class, inversedBy: 'commandes')]
    private $produits;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: Burger::class)]
    private $burgers;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
        $this->burgers = new ArrayCollection();
    }

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

    public function getGestionaire(): ?Gestionaire
    {
        return $this->gestionaire;
    }

    public function setGestionaire(?Gestionaire $gestionaire): self
    {
        $this->gestionaire = $gestionaire;

        return $this;
    }

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): self
    {
        $this->livraison = $livraison;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        $this->produits->removeElement($produit);

        return $this;
    }

    /**
     * @return Collection<int, Burger>
     */
    public function getBurgers(): Collection
    {
        return $this->burgers;
    }

    public function addBurger(Burger $burger): self
    {
        if (!$this->burgers->contains($burger)) {
            $this->burgers[] = $burger;
            $burger->setCommande($this);
        }

        return $this;
    }

    public function removeBurger(Burger $burger): self
    {
        if ($this->burgers->removeElement($burger)) {
            // set the owning side to null (unless already changed)
            if ($burger->getCommande() === $this) {
                $burger->setCommande(null);
            }
        }

        return $this;
    }

}
