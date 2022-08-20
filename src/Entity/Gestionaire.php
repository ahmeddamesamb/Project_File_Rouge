<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\GestionaireRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;
#[ApiResource()]
#[ORM\Entity(repositoryClass: GestionaireRepository::class)]
class Gestionaire extends User
{
    #[ORM\OneToMany(mappedBy: 'gestionaire', targetEntity: Client::class)]
    private $clients;

    #[ORM\OneToMany(mappedBy: 'gestionaire', targetEntity: Livreur::class)]
    private $livreurs;

    #[ORM\OneToMany(mappedBy: 'gestionaire', targetEntity: Livraison::class)]
    private $livraisons;

    #[ORM\OneToMany(mappedBy: 'gestionaire', targetEntity: Commande::class)]
    private $commandes;

    #[ORM\OneToMany(mappedBy: 'gestionaire', targetEntity: Produit::class)]
    private $produits;

    #[ORM\OneToMany(mappedBy: 'gestionaire', targetEntity: Zone::class)]
    private Collection $zone;

    public function __construct()
    {
        parent::__construct();
        $this->clients = new ArrayCollection();
        $this->livreurs = new ArrayCollection();
        $this->livraisons = new ArrayCollection();
        $this->commandes = new ArrayCollection();
        $this->produits = new ArrayCollection();
        $this->zone = new ArrayCollection();
    }

    /**
     * @return Collection<int, Client>
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Client $client): self
    {
        if (!$this->clients->contains($client)) {
            $this->clients[] = $client;
            $client->setGestionaire($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->clients->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getGestionaire() === $this) {
                $client->setGestionaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Livreur>
     */
    public function getLivreurs(): Collection
    {
        return $this->livreurs;
    }

    public function addLivreur(Livreur $livreur): self
    {
        if (!$this->livreurs->contains($livreur)) {
            $this->livreurs[] = $livreur;
            $livreur->setGestionaire($this);
        }

        return $this;
    }

    public function removeLivreur(Livreur $livreur): self
    {
        if ($this->livreurs->removeElement($livreur)) {
            // set the owning side to null (unless already changed)
            if ($livreur->getGestionaire() === $this) {
                $livreur->setGestionaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Livraison>
     */
    public function getLivraisons(): Collection
    {
        return $this->livraisons;
    }

    public function addLivraison(Livraison $livraison): self
    {
        if (!$this->livraisons->contains($livraison)) {
            $this->livraisons[] = $livraison;
            $livraison->setGestionaire($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): self
    {
        if ($this->livraisons->removeElement($livraison)) {
            // set the owning side to null (unless already changed)
            if ($livraison->getGestionaire() === $this) {
                $livraison->setGestionaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setGestionaire($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getGestionaire() === $this) {
                $commande->setGestionaire(null);
            }
        }

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
            $produit->setGestionaire($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getGestionaire() === $this) {
                $produit->setGestionaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Zone>
     */
    public function getZone(): Collection
    {
        return $this->zone;
    }

    public function addZone(Zone $zone): self
    {
        if (!$this->zone->contains($zone)) {
            $this->zone->add($zone);
            $zone->setGestionaire($this);
        }

        return $this;
    }

    public function removeZone(Zone $zone): self
    {
        if ($this->zone->removeElement($zone)) {
            // set the owning side to null (unless already changed)
            if ($zone->getGestionaire() === $this) {
                $zone->setGestionaire(null);
            }
        }

        return $this;
    }

    }

