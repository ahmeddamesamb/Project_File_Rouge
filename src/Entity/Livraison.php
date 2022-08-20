<?php

namespace App\Entity;

use App\Entity\Commande;
use App\Entity\Gestionaire;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivraisonRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get" =>[
            "status" => Response::HTTP_OK,
            "normalization_context" =>['groups' => ['livraison:read']]
        ],
            "post"=>[
            "denormalization_context" =>['groups' => ['livraison:write']],
        ]
      ],
        itemOperations: [
            "put"=>[
                // "security"=>"is_granted('ROLE_GESTIONAIRE')"
                "security_message"=>"Access denied in this ressource"
            ],
            "get" =>[
                    "status" => Response::HTTP_OK,
                    "normalization_context" =>['groups' => ['livraison:read']],
            ]
        ]
)]
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(['livraison:write','livreur:read','livreur:write'])]
    private $telephoneLivraison;
    
    #[ORM\Column(type: 'string')]
    #[Groups(['livraison:read','livreur:read','livreur:write'])]
    private $etatLivraison="Commande en cours de Livraison";

    #[ORM\ManyToOne(targetEntity: Gestionaire::class, inversedBy: 'livraisons')]
    private $gestionaire;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'livraisons')]
    // #[Groups(['livraison:read','livraison:write'])]
    private $zone;

    #[ORM\OneToMany(mappedBy: 'livraison', targetEntity: Commande::class)]
    #[Groups(['livraison:read','livraison:write','livreur:read','livreur:write'])]
    private $commandes;

    #[ORM\ManyToOne(inversedBy: 'livraisons')]
    #[Groups(['livraison:read','livraison:write'])]
    private ?Livreur $livreur = null;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTelephoneLivraison(): ?int
    {
        return $this->telephoneLivraison;
    }

    public function setTelephoneLivraison(int $telephoneLivraison): self
    {
        $this->telephoneLivraison = $telephoneLivraison;

        return $this;
    }

    public function isEtatLivraison(): ?string
    {
        return $this->etatLivraison;
    }

    public function setEtatLivraison(string $etatLivraison): self
    {
        $this->etatLivraison = $etatLivraison;

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

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

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
            $commande->setLivraison($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getLivraison() === $this) {
                $commande->setLivraison(null);
            }
        }

        return $this;
    }

    public function getLivreur(): ?Livreur
    {
        return $this->livreur;
    }

    public function setLivreur(?Livreur $livreur): self
    {
        $this->livreur = $livreur;

        return $this;
    }


}
