<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BurgerRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
#[ORM\HasLifecycleCallbacks]

#[ApiResource(
    collectionOperations:[
      "get" =>[
          "status" => Response::HTTP_OK,
          "normalization_context" =>['groups' => ['burger:read']]
      ],
          "post"=>[
          "denormalization_context" =>['groups' => ['burger:write']],
      ]
    ],
      itemOperations: [
          "put"=>[
              "security"=>"is_granted('ROLE_GESTIONAIRE')",
              "security_message"=>"Access denied in this ressource"
          ],
          "get" =>[
                  "status" => Response::HTTP_OK,
                  "normalization_context" =>['groups' => ['burger:read']],
          ]
      ]
  )]
class Burger extends Produit
{

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'burgers')]
    private $commande;

    #[ORM\OneToMany(mappedBy: 'burger', targetEntity: MenuBurger::class)]
    private $menuBurgers;



    public function __construct()
    {
        parent::__construct();
        $this->menuBurgers = new ArrayCollection();


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
     * @return Collection<int, MenuBurger>
     */
    public function getMenuBurgers(): Collection
    {
        return $this->menuBurgers;
    }

    public function addMenuBurger(MenuBurger $menuBurger): self
    {
        if (!$this->menuBurgers->contains($menuBurger)) {
            $this->menuBurgers[] = $menuBurger;
            $menuBurger->setBurger($this);
        }

        return $this;
    }

    public function removeMenuBurger(MenuBurger $menuBurger): self
    {
        if ($this->menuBurgers->removeElement($menuBurger)) {
            // set the owning side to null (unless already changed)
            if ($menuBurger->getBurger() === $this) {
                $menuBurger->setBurger(null);
            }
        }

        return $this;
    }

}
