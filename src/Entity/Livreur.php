<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivreurRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
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
        parent::__construct();
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
