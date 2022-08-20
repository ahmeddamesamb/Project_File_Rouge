<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ZoneRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ZoneRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get" =>[
        "status" => Response::HTTP_OK,
        "normalization_context" =>['groups' => ['zone:read']]
    ],
    "post"=>[
        "denormalization_context" =>['groups' => ['zone:write']], 
    
    ]],
     itemOperations:[
        "put"=>[
            "security"=>"is_granted('ROLE_GESTIONAIRE')",
            "security_message"=>"Access denied in this ressource"
        ],
        "get" =>[
                "status" => Response::HTTP_OK,
                "normalization_context" =>['groups' => ['zone:read']],
        ]
        ]
    )]
class Zone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['zone:write','zone:read','commande:read'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['zone:write','zone:read','commande:read'])]
    private $nomZone;

    #[ORM\Column(type: 'integer')]
    #[Groups(['zone:write','zone:read','commande:read'])]
    private $coutLivraison;

    #[ORM\Column(type: 'string')]
    #[Groups(['zone:write','zone:read','commande:read'])]
    private $etatZone;

    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Livraison::class)]
    private $livraisons;

    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Commande::class)]
    #[Groups(['zone:write','zone:read','commande:read'])]
    #[ApiSubresource()]
    private Collection $commandes;

    #[ORM\ManyToOne(inversedBy: 'zone')]
    private ?Gestionaire $gestionaire = null;



    public function __construct()
    {
        $this->livraisons = new ArrayCollection();
        $this->quartiers = new ArrayCollection();
        $this->commandes = new ArrayCollection();
    }

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

    public function isEtatZone(): ?string
    {
        return $this->etatZone;
    }

    public function setEtatZone(string $etatZone): self
    {
        $this->etatZone = $etatZone;

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
            $livraison->setZone($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): self
    {
        if ($this->livraisons->removeElement($livraison)) {
            // set the owning side to null (unless already changed)
            if ($livraison->getZone() === $this) {
                $livraison->setZone(null);
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
            $this->commandes->add($commande);
            $commande->setZone($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getZone() === $this) {
                $commande->setZone(null);
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
