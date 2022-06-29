<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BoissonRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BoissonRepository::class)]
#[ApiResource]
class Boisson extends Produit
{
    #[ORM\Column(type: 'string', length: 255)]
    private $tailleBoisson;
    public function getTailleBoisson(): ?string
    {
        return $this->tailleBoisson;
    }

    public function setTailleBoisson(string $tailleBoisson): self
    {
        $this->tailleBoisson = $tailleBoisson;

        return $this;
    }
}
