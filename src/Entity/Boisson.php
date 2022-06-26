<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BoissonRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BoissonRepository::class)]
#[ApiResource]
class Boisson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $tailleBoisson;

    public function getId(): ?int
    {
        return $this->id;
    }

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
