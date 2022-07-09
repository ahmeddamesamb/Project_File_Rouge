<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FriteRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FriteRepository::class)]
#[ApiResource]
class Frite extends Produit
{

    #[ORM\OneToMany(mappedBy: 'frite', targetEntity: MenuFrite::class)]
    private $menuFrites;

    #[ORM\Column(type: 'string', length: 255)]
    private $quantiteFrite;
    

    public function __construct()
    {
        parent::__construct();
        $this->menuFrites = new ArrayCollection();
    
    }

   
    /**
     * @return Collection<int, MenuFrite>
     */
    public function getMenuFrites(): Collection
    {
        return $this->menuFrites;
    }

    public function addMenuFrite(MenuFrite $menuFrite): self
    {
        if (!$this->menuFrites->contains($menuFrite)) {
            $this->menuFrites[] = $menuFrite;
            $menuFrite->setFrite($this);
        }

        return $this;
    }

    public function removeMenuFrite(MenuFrite $menuFrite): self
    {
        if ($this->menuFrites->removeElement($menuFrite)) {
            // set the owning side to null (unless already changed)
            if ($menuFrite->getFrite() === $this) {
                $menuFrite->setFrite(null);
            }
        }

        return $this;
    }

    public function getQuantiteFrite(): ?string
    {
        return $this->quantiteFrite;
    }

    public function setQuantiteFrite(string $quantiteFrite): self
    {
        $this->quantiteFrite = $quantiteFrite;

        return $this;
    }
   
}
