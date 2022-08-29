<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get" =>[
        "status" => Response::HTTP_OK,
        "normalization_context" =>['groups' => ['commande:read']]
    ],
    "post"=>[
        "denormalization_context" =>['groups' => ['commande:write']], 
    ]],
    itemOperations: [
        "put"=>[
            // "security"=>"is_granted('ROLE_CLIENT')",
            // "security_message"=>"Access denied in this ressource"
        ],
        "get" =>[
                "status" => Response::HTTP_OK,
                "normalization_context" =>['groups' => ['commande:read']],
        ]
    ]
    )]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['commande:write','commande:read','boisson:read:simple','lignecommande:read','livreur:read','livraison:read','livraison:write','zone:write','zone:read','client:read'])] 
    private $id;
    
    #[ORM\Column(type: 'string',length:50)]
    #[Groups(['boisson:read:simple','commande:read','commande:write','livraison:read','livraison:write','client:read','livreur:read','livreur:write'])]
    private $etatCommande='en cours';
    
    #[ORM\Column(type: 'string',nullable:true)]
    #[Groups(['commande:read','boisson:read:simple','lignecommande:read','zone:write','zone:read','livraison:read','livraison:write','client:read','livreur:read','livreur:write'])] 
    private $numeroCommande;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['boisson:read:simple','commande:read','commande:write','livraison:read','livraison:write','client:read','livreur:read','livreur:write','zone:read'])]
    private $dateCommande;
    

    #[ORM\Column(type: 'string',nullable:true)]
    #[Groups(['boisson:read:simple','zone:write','zone:read','client:read','livreur:read','livreur:write'])]
    private $statutCommande;

    #[ORM\Column(type: 'integer',nullable:true)]
    private $paiement;


    #[ORM\ManyToOne(targetEntity: Gestionaire::class, inversedBy: 'commandes')]
    private $gestionaire;

    #[ORM\ManyToOne(targetEntity: Livraison::class, inversedBy: 'commandes')]
    // #[Groups(['boisson:read:simple','commande:read','commande:write','client:read'])]
    private $livraison;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes')]
    // #[ApiSubresource()]
    #[Groups(['commande:write','commande:read','boisson:read:simple','zone:write','zone:read'])] 
    private $client;
    
    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: Burger::class)]
    private $burgers;

    #[ORM\OneToMany(mappedBy: 'commande',cascade:['persist'], targetEntity: LigneCommande::class)]
    #[Groups(['boisson:read:simple','commande:write','commande:read','zone:read'])]
    #[SerializedName('Produits')]
    private $ligneCommandes;

   
    #[ORM\ManyToOne(inversedBy: 'commandes')]
    #[Groups(['commande:read','commande:write'])]
    private ?Zone $zone = null;

    #[ORM\Column(nullable: true)]
    private ?int $code = null;


    public function __construct()
    {
        $this->dateCommande = new \DateTime('now');
        $this->burgers = new ArrayCollection();
        $this->ligneCommandes = new ArrayCollection();
        $this->numeroCommande='NUM_'.time();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isEtatCommande(): ?string
    {
        return $this->etatCommande;
    }

    public function setEtatCommande(string $etatCommande): self
    {
        $this->etatCommande = $etatCommande;

        return $this;
    }

    public function getNumeroCommande(): ?string
    {
        return $this->numeroCommande;
    }

    public function setNumeroCommande(string $numeroCommande): self
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


    public function getStatutCommande(): ?string
    {
        return $this->statutCommande;
    }

    public function setStatutCommande(string $statutCommande): self
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

    /**
     * @return Collection<int, LigneCommande>
     */
    public function getLigneCommandes(): Collection
    {
        return $this->ligneCommandes;
    }

    public function addLigneCommande(LigneCommande $ligneCommande): self
    {
        if (!$this->ligneCommandes->contains($ligneCommande)) {
            $this->ligneCommandes[] = $ligneCommande;
            $ligneCommande->setCommande($this);
        }

        return $this;
    }

    public function removeLigneCommande(LigneCommande $ligneCommande): self
    {
        if ($this->ligneCommandes->removeElement($ligneCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneCommande->getCommande() === $this) {
                $ligneCommande->setCommande(null);
            }
        }

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

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(?int $code): self
    {
        $this->code = $code;

        return $this;
    }


}
