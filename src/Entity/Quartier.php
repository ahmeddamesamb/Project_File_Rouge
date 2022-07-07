<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\QuartierRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;

#[ORM\Entity(repositoryClass: QuartierRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get" =>[
        "status" => Response::HTTP_OK,
        "normalization_context" =>['groups' => ['quartier:read:simple']]
    ],
    "post"=>[
        "denormalization_context" =>['groups' => ['write']], 
    
    ]],
     itemOperations:[
        "put"=>[
            "security"=>"is_granted('ROLE_GESTIONAIRE')",
            "security_message"=>"Access denied in this ressource"
        ],
        "get" =>[
                "status" => Response::HTTP_OK,
                "normalization_context" =>['groups' => ['quartier:read:all']],
        ]
        ]
    )]
class Quartier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]



    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nomQuartier;

    #[ORM\Column(type: 'boolean')]
    private $etatQuartier;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'quartiers')]
    private $zone;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomQuartier(): ?string
    {
        return $this->nomQuartier;
    }

    public function setNomQuartier(string $nomQuartier): self
    {
        $this->nomQuartier = $nomQuartier;

        return $this;
    }

    public function isEtatQuartier(): ?bool
    {
        return $this->etatQuartier;
    }

    public function setEtatQuartier(bool $etatQuartier): self
    {
        $this->etatQuartier = $etatQuartier;

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

}
