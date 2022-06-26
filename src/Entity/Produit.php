<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource]
#[ORM\Table(name: '`produit`')]
#[ORM\Entity(repositoryClass: ProduitRepository::class)]
// #[ORM\InheritanceType("JOINED")]
// #[ORM\DiscriminatorColumn(name:"desc",type:"string")]
// #[ORM\DiscriminatorMap(["complement"=>"Complement","menu"=>"Menu","burger"=>"Burger"])]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[ORM\Column(type: 'string', length: 255)]
    protected $image;

    #[ORM\Column(type: 'string', length: 255)]
    protected $description;

    #[ORM\Column(type: 'string', length: 255)]
    protected $nom;

    #[ORM\Column(type: 'integer')]
    protected $prix;

    #[ORM\Column(type: 'boolean')]
    protected $etatProduit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function isEtatProduit(): ?bool
    {
        return $this->etatProduit;
    }

    public function setEtatProduit(bool $etatProduit): self
    {
        $this->etatProduit = $etatProduit;

        return $this;
    }
}
