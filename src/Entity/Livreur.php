<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivreurRepository;
use ApiPlatform\Core\Annotation\ApiResource;
#[ApiResource()]
#[ORM\Entity(repositoryClass: LivreurRepository::class)]
class Livreur extends User
{
 

    #[ORM\Column(type: 'string', length: 255)]
    private $matriculeMoto;

 

    public function getMatriculeMoto(): ?string
    {
        return $this->matriculeMoto;
    }

    public function setMatriculeMoto(string $matriculeMoto): self
    {
        $this->matriculeMoto = $matriculeMoto;

        return $this;
    }
}
