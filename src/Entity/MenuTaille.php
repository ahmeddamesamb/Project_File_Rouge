<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuTailleRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MenuTailleRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get" =>[
            "status" => Response::HTTP_OK,
            "normalization_context" =>['groups' => ['Menutaille:read']]
        ],
            "post"=>[
            "denormalization_context" =>['groups' => ['Menutaille:write']],
        ]
      ],
        itemOperations: [
            "put"=>[
                "security"=>"is_granted('ROLE_GESTIONAIRE')",
                "security_message"=>"Access denied in this ressource"
            ],
            "get" =>[
                    "status" => Response::HTTP_OK,
                    "normalization_context" =>['groups' => ['Menutaille:read']],
            ]
        ]
)]
class MenuTaille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['Menutaille:write','Menutaille:read','menu:write','menu:read'])]
    private ?int $quantity = null;
    
    #[ORM\ManyToOne(inversedBy: 'menutailles')]
    #[Groups(['Menutaille:write','Menutaille:read'])]
    private ?Menu $menu = null;
    
    #[ORM\ManyToOne(inversedBy: 'menuTailles')]
    #[Groups(['Menutaille:write','Menutaille:read','menu:write','menu:read'])]
    private ?Taille $taille = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

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
}
