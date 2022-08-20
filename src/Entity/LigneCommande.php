<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LigneCommandeRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LigneCommandeRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get" =>[
        "status" => Response::HTTP_OK,
        "normalization_context" =>['groups' => ['lignecommande:read']]
    ],
    "post"=>[
        "denormalization_context" =>['groups' => ['lignecommande:write']], 
    ]],
     itemOperations:[
        "put"=>[
            "security"=>"is_granted('ROLE_CLIENT')",
            "security_message"=>"Access denied in this ressource"
        ],
        "get" =>[
                "status" => Response::HTTP_OK,
                "normalization_context" =>['groups' => ['lignecommande:read']],
        ]
        ]
    )]

 
class LigneCommande
{
     
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['boisson:read:simple','commande:read','commande:write','lignecommande:read'])]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(['boisson:read:simple','commande:read','commande:write','lignecommande:read','zone:write','zone:read'])]
    private $quantite;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'ligneCommandes')]
    private $commande;

    #[ORM\ManyToOne(targetEntity: Produit::class, inversedBy: 'ligneCommandes')]
    #[Groups(['commande:write','commande:read','boisson:read','lignecommande:read','zone:write','zone:read'])]
    private $produit;

    #[ORM\Column(type: 'integer',nullable:true)]
    private $prix;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

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
}
