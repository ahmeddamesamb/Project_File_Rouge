<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource]
class Menu extends Produit
{
  
    #[ORM\Column(type: 'string', length: 255)]
    private $nomMenu;

    #[ORM\ManyToMany(targetEntity: Burger::class, mappedBy: 'menus')]
    private $burgers;


    public function __construct()
    {
        $this->burgers = new ArrayCollection();
    }

   
    public function getNomMenu(): ?string
    {
        return $this->nomMenu;
    }

    public function setNomMenu(string $nomMenu): self
    {
        $this->nomMenu = $nomMenu;

        return $this;
    }

    /**
     * @return Collection<int, Burger>
     */
    public function getBurgers(): Collection
    {
        return $this->burgers;
    }

    public function addBurger(Burger $burger): self
    {
        if (!$this->burgers->contains($burger)) {
            $this->burgers[] = $burger;
            $burger->addMenu($this);
        }

        return $this;
    }

    public function removeBurger(Burger $burger): self
    {
        if ($this->burgers->removeElement($burger)) {
            $burger->removeMenu($this);
        }

        return $this;
    }

}
