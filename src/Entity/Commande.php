<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get" =>[
        "status" => Response::HTTP_OK,
        "normalization_context" =>['groups' => ['boisson:read:simple']]
    ],
    "post"=>[
        "denormalization_context" =>['groups' => ['write']], 
    ]],
     itemOperations:[
        "put"=>[
            "security"=>"is_granted('ROLE_CLIENT')",
            "security_message"=>"Access denied in this ressource"
        ],
        "get" =>[
                "status" => Response::HTTP_OK,
                "normalization_context" =>['groups' => ['boisson:read:all']],
        ]
        ]
    )]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'boolean')]
    private $etatCommande=1;

    #[ORM\Column(type: 'string',nullable:true)]
    private $numeroCommande;

    #[ORM\Column(type: 'datetime')]
    private $dateCommande;

    #[ORM\Column(type: 'boolean')]
    private $etatPaiement=1;

    #[ORM\Column(type: 'string',nullable:true)]
    #[Groups(["write",'boisson:read:simple'])]

    private $statutCommande;

    #[ORM\Column(type: 'integer',nullable:true)]
    private $paiement;

    #[ORM\Column(type: 'integer',nullable:true)]
    private $numeroTicket;

    #[ORM\ManyToOne(targetEntity: Gestionaire::class, inversedBy: 'commandes')]
    private $gestionaire;

    #[ORM\ManyToOne(targetEntity: Livraison::class, inversedBy: 'commandes')]
    private $livraison;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes')]
    #[Groups(["write",'boisson:read:simple'])]

    private $client;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: Burger::class)]
    private $burgers;

    #[ORM\OneToMany(mappedBy: 'commande',cascade:['persist'], targetEntity: LigneCommande::class)]
    #[Groups(["write",'boisson:read:simple'])]
    #[SerializedName('Produits')]
    private $ligneCommandes;

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

    public function isEtatCommande(): ?bool
    {
        return $this->etatCommande;
    }

    public function setEtatCommande(bool $etatCommande): self
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

    public function isEtatPaiement(): ?bool
    {
        return $this->etatPaiement;
    }

    public function setEtatPaiement(bool $etatPaiement): self
    {
        $this->etatPaiement = $etatPaiement;

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

}
