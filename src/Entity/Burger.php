<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BurgerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
#[ApiResource]
class Burger extends Produit
{
  
    #[ORM\Column(type: 'string', length: 255)]
    private $catrgorie;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'burgers')]
    private $commande;

    #[ORM\ManyToMany(targetEntity: Menu::class, inversedBy: 'burgers')]
    private $menus;

    public function __construct()
    {
        //parent::__construct();
        $this->menus = new ArrayCollection();

    }


    public function getCatrgorie(): ?string
    {
        return $this->catrgorie;
    }

    public function setCatrgorie(string $catrgorie): self
    {
        $this->catrgorie = $catrgorie;

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

    /**
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        $this->menus->removeElement($menu);

        return $this;
    }

}
