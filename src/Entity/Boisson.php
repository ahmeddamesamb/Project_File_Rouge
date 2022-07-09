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
#[ApiResource()]
class Boisson extends Produit
{

    #[ORM\ManyToOne(targetEntity: TailleBoisson::class, inversedBy: 'boissons')]
    
    private $tailleBoissons;

    #[ORM\OneToMany(mappedBy: 'boisson', targetEntity: MenuBoisson::class)]
    private $menuBoissons;

    public function __construct()
    {
        parent::__construct();
        $this->menuBoissons = new ArrayCollection();
    }

    public function getTailleBoissons(): ?TailleBoisson
    {
        return $this->tailleBoissons;
    }

    public function setTailleBoissons(?TailleBoisson $tailleBoissons): self
    {
        $this->tailleBoissons = $tailleBoissons;

        return $this;
    }

    /**
     * @return Collection<int, MenuBoisson>
     */
    public function getMenuBoissons(): Collection
    {
        return $this->menuBoissons;
    }

    public function addMenuBoisson(MenuBoisson $menuBoisson): self
    {
        if (!$this->menuBoissons->contains($menuBoisson)) {
            $this->menuBoissons[] = $menuBoisson;
            $menuBoisson->setBoisson($this);
        }

        return $this;
    }

    public function removeMenuBoisson(MenuBoisson $menuBoisson): self
    {
        if ($this->menuBoissons->removeElement($menuBoisson)) {
            // set the owning side to null (unless already changed)
            if ($menuBoisson->getBoisson() === $this) {
                $menuBoisson->setBoisson(null);
            }
        }

        return $this;
    }

}
