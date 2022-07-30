<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    collectionOperations:[
      "get" =>[
          "status" => Response::HTTP_OK,
          "normalization_context" =>['groups' => ['produit:read:simple']]
      ],
          "post"=>[
          "denormalization_context" =>['groups' => ['produit:write']],
      ]
    ],
      itemOperations: [
          "put"=>[
              "security"=>"is_granted('ROLE_GESTIONAIRE')",
              "security_message"=>"Access denied in this ressource"
          ],
          "get" =>[
                  "status" => Response::HTTP_OK,
                  "normalization_context" =>['groups' => ['produit:read:all']],
          ]
      ]
  )]
#[ORM\Table(name: '`produit`')]
#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name:"type",type:"string")]
#[ORM\DiscriminatorMap(["boisson"=>"Boisson","menu"=>"Menu","burger"=>"Burger","frite"=>"Frite"])]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    
    protected $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["produit:write","burger:write"])]
    protected $image;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["produit:write","burger:write"])]
    protected $description = "Produitde premiere qualité";

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["produit:write","burger:write"])]
    protected $nom;

    #[ORM\Column(type: 'integer')]
    #[Groups(["produit:write","burger:write"])]
    protected $prix ;

    #[ORM\Column(type: 'boolean')]
    protected $etatProduit=true;


    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: LigneCommande::class)]
    
    private $ligneCommandes;

    #[ORM\ManyToOne(targetEntity: Gestionaire::class, inversedBy: 'produits')]
    
    private $gestionaire;

    public function __construct()
    {
        $this->ligneCommandes = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, LigneCommande>
     */
    // public function getLigneCommandes(): Collection
    // {
    //     return $this->ligneCommandes;
    // }

    public function addLigneCommande(LigneCommande $ligneCommande): self
    {
        if (!$this->ligneCommandes->contains($ligneCommande)) {
            $this->ligneCommandes[] = $ligneCommande;
            $ligneCommande->setProduit($this);
        }

        return $this;
    }

    public function removeLigneCommande(LigneCommande $ligneCommande): self
    {
        if ($this->ligneCommandes->removeElement($ligneCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneCommande->getProduit() === $this) {
                $ligneCommande->setProduit(null);
            }
        }

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

}
