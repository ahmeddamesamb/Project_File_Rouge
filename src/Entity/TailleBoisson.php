<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TailleBoissonRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TailleBoissonRepository::class)]
#[ApiResource(
    collectionOperations:[
      "get" =>[
          "status" => Response::HTTP_OK,
          "normalization_context" =>['groups' => ['tailleBoisson:read']]
      ],
          "post"=>[
          "denormalization_context" =>['groups' => ['tailleBoisson:write']],
      ]
    ],
      itemOperations: [
          "put"=>[
              "security"=>"is_granted('ROLE_GESTIONAIRE')",
              "security_message"=>"Access denied in this ressource"
          ],
          "get" =>[
                  "status" => Response::HTTP_OK,
                  "normalization_context" =>['groups' => ['tailleBoisson:read']],
          ]
      ]
  )]class TailleBoisson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]

    private $id;

    #[ORM\Column(type: 'integer', length: 255)]
    #[Groups(['tailleBoisson:write'])]
    private $taille;

    #[ORM\OneToMany(mappedBy: 'tailleBoissons', targetEntity: Boisson::class)]
    #[Groups(['tailleBoisson:write'])]
    private $boissons;

    public function __construct()
    {
        $this->menus = new ArrayCollection();
        $this->boissons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTaille(): ?int
    {
        return $this->taille;
    }

    public function setTaille(int $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    /**
     * @return Collection<int, Boisson>
     */
    public function getBoissons(): Collection
    {
        return $this->boissons;
    }

    public function addBoisson(Boisson $boisson): self
    {
        if (!$this->boissons->contains($boisson)) {
            $this->boissons[] = $boisson;
            $boisson->setTailleBoissons($this);
        }

        return $this;
    }

    public function removeBoisson(Boisson $boisson): self
    {
        if ($this->boissons->removeElement($boisson)) {
            // set the owning side to null (unless already changed)
            if ($boisson->getTailleBoissons() === $this) {
                $boisson->setTailleBoissons(null);
            }
        }

        return $this;
    }

}
