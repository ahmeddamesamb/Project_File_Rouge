<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BoissonRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BoissonRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get" =>[
            "status" => Response::HTTP_OK,
            "normalization_context" =>['groups' => ['Boisson:read']]
        ],
            "post"=>[
            "denormalization_context" =>['groups' => ['Boisson:write']],
        ]
      ],
        itemOperations: [
            "put"=>[
                "security"=>"is_granted('ROLE_GESTIONAIRE')",
                "security_message"=>"Access denied in this ressource"
            ],
            "get" =>[
                    "status" => Response::HTTP_OK,
                    "normalization_context" =>['groups' => ['Boisson:read']],
            ]
        ]
)]
class Boisson extends Produit
{
    #[ORM\OneToMany(mappedBy: 'boisson', targetEntity: Tailleboisson::class,cascade:['persist'])]
    private Collection $tailleBoissons;

    public function __construct()
    {
        parent::__construct();
        $this->tailleBoissons = new ArrayCollection();
    }

    /**
     * @return Collection<int, Tailleboisson>
     */
    public function getTailleBoissons(): Collection
    {
        return $this->tailleBoissons;
    }

    public function addTailleBoisson(Tailleboisson $tailleBoisson): self
    {
        if (!$this->tailleBoissons->contains($tailleBoisson)) {
            $this->tailleBoissons->add($tailleBoisson);
            $tailleBoisson->setBoisson($this);
        }

        return $this;
    }

    public function removeTailleBoisson(Tailleboisson $tailleBoisson): self
    {
        if ($this->tailleBoissons->removeElement($tailleBoisson)) {
            // set the owning side to null (unless already changed)
            if ($tailleBoisson->getBoisson() === $this) {
                $tailleBoisson->setBoisson(null);
            }
        }

        return $this;
    }




}
