<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TailleboissonRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: TailleboissonRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get" =>[
            "status" => Response::HTTP_OK,
            "normalization_context" =>['groups' => ['TailleBoisson:read']]
        ],
            "post"=>[
            "denormalization_context" =>['groups' => ['TailleBoisson:write']],
        ]
      ],
        itemOperations: [
            "put"=>[
                "security"=>"is_granted('ROLE_GESTIONAIRE')",
                "security_message"=>"Access denied in this ressource"
            ],
            "get" =>[
                    "status" => Response::HTTP_OK,
                    "normalization_context" =>['groups' => ['TailleBoisson:read']],
            ]
        ]
)]
class Tailleboisson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['TailleBoisson:write','TailleBoisson:read','menu:read'])]
    private ?int $quantiteStock = null;

    #[ORM\ManyToOne(inversedBy: 'tailleBoissons',cascade:['persist'])]
    #[Groups(['TailleBoisson:write','TailleBoisson:read'])]
    private ?Taille $taille = null;
    
    #[ORM\ManyToOne(inversedBy: 'tailleBoissons',cascade:['persist'])]
    #[Groups(['TailleBoisson:write','TailleBoisson:read','menu:read'])]
    private ?Boisson $boisson = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantiteStock(): ?int
    {
        return $this->quantiteStock;
    }

    public function setQuantiteStock(int $quantiteStock): self
    {
        $this->quantiteStock = $quantiteStock;

        return $this;
    }

    public function getTaille(): ?Taille
    {
        return $this->taille;
    }

    public function setTaille(?Taille $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getBoisson(): ?Boisson
    {
        return $this->boisson;
    }

    public function setBoisson(?Boisson $boisson): self
    {
        $this->boisson = $boisson;

        return $this;
    }
}
