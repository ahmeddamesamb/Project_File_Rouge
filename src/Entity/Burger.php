<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BurgerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
#[ApiResource]
class Burger
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $catrgorie;

    public function getId(): ?int
    {
        return $this->id;
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
}
