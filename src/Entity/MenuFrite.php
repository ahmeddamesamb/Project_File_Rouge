<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuFriteRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;
// use Symfony\Component\Validator\Constraints\Cascade;

#[ORM\Entity(repositoryClass: MenuFriteRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get" =>[
            "status" => Response::HTTP_OK,
            "normalization_context" =>['groups' => ['MenuFrite:read']]
        ],
            "post"=>[
            "denormalization_context" =>['groups' => ['MenuFrite:write']],
        ]
      ],
        itemOperations: [
            "put"=>[
                "security"=>"is_granted('ROLE_GESTIONAIRE')",
                "security_message"=>"Access denied in this ressource"
            ],
            "get" =>[
                    "status" => Response::HTTP_OK,
                    "normalization_context" =>['groups' => ['MenuFrite:read']],
            ]
        ]
)]
class MenuFrite
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(['menu:read','menu:write','Frite:write','Frite:read','MenuFrite:read'])]
    private $quantiteFrite;
    
    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menuFrites')]
    private $menu;
    
    #[ORM\ManyToOne(targetEntity: Frite::class, inversedBy: 'menuFrites')]
    #[Groups(['menu:read','menu:write','Frite:write','Frite:read','MenuFrite:read'])]
    private $frite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantiteFrite(): ?int
    {
        return $this->quantiteFrite;
    }

    public function setQuantiteFrite(int $quantiteFrite): self
    {
        $this->quantiteFrite = $quantiteFrite;

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

    public function getFrite(): ?Frite
    {
        return $this->frite;
    }

    public function setFrite(?Frite $frite): self
    {
        $this->frite = $frite;

        return $this;
    }
}
