<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivreurRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
#[ApiResource(

        collectionOperations:[
        "get" =>[
            "status" => Response::HTTP_OK,
            "normalization_context" =>['groups' => ['livreur:read']]
        ],
            "post"=>[
            // "denormalization_context" =>['groups' => ['livreur:write']],
        ]
      ],
        itemOperations: [
            "put"=>[
                "security"=>"is_granted('ROLE_GESTIONAIRE')",
                "security_message"=>"Access denied in this ressource"
            ],
            "get" =>[
                    "status" => Response::HTTP_OK,
                    "normalization_context" =>['groups' => ['livreur:read']],
            ]
        ]
)]
#[ORM\Entity(repositoryClass: LivreurRepository::class)]
class Livreur extends User
{

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['livraison:read','livraison:write'])] 
    private $matriculeMoto;

    #[ORM\ManyToOne(targetEntity: Gestionaire::class, inversedBy: 'livreurs')]
    private $gestionaire;
    
    #[ORM\OneToMany(mappedBy: 'livreur', targetEntity: Livraison::class)]
    #[ApiSubresource()]
    #[Groups(['livreur:read','livreur:write','livraison:read'])] 
    private Collection $livraisons;

    public function __construct()
    {
        parent::__construct();
        $this->matriculeMoto='MAT'.date('YmdHis') ;
        $this->livraisons = new ArrayCollection();
    }  
    public function getMatriculeMoto(): ?string
    {
        return $this->matriculeMoto;
    }
    public function setMatriculeMoto(string $matriculeMoto): self
    {
        $this->matriculeMoto = $matriculeMoto;
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
            $this->livraisons->add($livraison);
            $livraison->setLivreur($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): self
    {
        if ($this->livraisons->removeElement($livraison)) {
            // set the owning side to null (unless already changed)
            if ($livraison->getLivreur() === $this) {
                $livraison->setLivreur(null);
            }
        }

        return $this;
    }

}
