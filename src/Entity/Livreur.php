<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivreurRepository;
use ApiPlatform\Core\Annotation\ApiResource;
#[ApiResource()]
#[ORM\Entity(repositoryClass: LivreurRepository::class)]
class Livreur extends User
{
 

    #[ORM\Column(type: 'string', length: 255)]
    private $matriculeMoto;

    #[ORM\ManyToOne(targetEntity: Gestionaire::class, inversedBy: 'livreurs')]
    private $gestionaire;

    public function __construct()
    {
        $this->matriculeMoto='MAT'.date('YmdHis') ;
    }

    public function getMatriculeMoto(): ?string
    {
        return $this->matriculeMoto;
    }

    public function setMatriculeMoto(string $matriculeMoto): self
    {
        $this->matriculeMoto = $matriculeMoto;

        return $this;
    }

    public function getGestionaire(): ?Gestionaire
    {
        return $this->gestionaire;
    }

    public function setGestionaire(?Gestionaire $gestionaire): self
    {
        $this->gestionaire = $gestionaire;

        return $this;
    }

}
