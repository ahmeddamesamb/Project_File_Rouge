<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\MenuAddController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use PhpParser\Node\Expr\Cast;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints\Cascade;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get" =>[
        "status" => Response::HTTP_OK,
        "normalization_context" =>['groups' => ['menu:read']]
    ],
    "post"=>[
        "denormalization_context" =>['groups' => ['menu:write']], 
    ]
],
     itemOperations:[
        "put"=>[
            "security"=>"is_granted('ROLE_GESTIONAIRE')",
            "security_message"=>"Access denied in this ressource"
        ],
        "get" =>[
                "status" => Response::HTTP_OK,
                "normalization_context" =>['groups' => ['menu:read']],
        ]
        ]
    )]

class Menu extends Produit
{
  
    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuBurger::class,cascade:['persist'])]
    #[Groups(['menu:write','menu:read','Burger:read'])]
        #[SerializedName('Burgers')]
    private $menuBurgers;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuFrite::class,cascade:['persist'])]
    #[Groups(['menu:write','menu:read','Burger:read'])]
    #[SerializedName('Frites')]
    private $menuFrites;
    
    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuTaille::class,cascade:['persist'])]
    #[Groups(['menu:write','menu:read','Burger:read'])]
    private Collection $menutailles;

    public function __construct()
    {
        parent::__construct();
        $this->menuBurgers = new ArrayCollection();
        $this->menuFrites = new ArrayCollection();
        $this->menutailles = new ArrayCollection();
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
            $menuBurger->setMenu($this);
        }

        return $this;
    }

    public function removeMenuBurger(MenuBurger $menuBurger): self
    {
        if ($this->menuBurgers->removeElement($menuBurger)) {
            // set the owning side to null (unless already changed)
            if ($menuBurger->getMenu() === $this) {
                $menuBurger->setMenu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MenuFrite>
     */
    public function getMenuFrites(): Collection
    {
        return $this->menuFrites;
    }

    public function addMenuFrite(MenuFrite $menuFrite): self
    {
        if (!$this->menuFrites->contains($menuFrite)) {
            $this->menuFrites[] = $menuFrite;
            $menuFrite->setMenu($this);
        }

        return $this;
    }

    public function removeMenuFrite(MenuFrite $menuFrite): self
    {
        if ($this->menuFrites->removeElement($menuFrite)) {
            // set the owning side to null (unless already changed)
            if ($menuFrite->getMenu() === $this) {
                $menuFrite->setMenu(null);
            }
        }

        return $this;
    }
    //**METHODE PERMETTANT D AJOUTER UN BURGER**
    public function addBurger(Burger $burger,int $qt=1){
        $Mburg= new MenuBurger();
        $Mburg->setBurger($burger);
        $Mburg->setQuantiteBurger($qt);
        $Mburg->setMenu($this);
        $this->addMenuBurger($Mburg);
    }
    //**METHODE PERMETTANT D AJOUTER UN FRITE**
    public function addFrite(Frite $frite,int $qt=1){
        $Mfrit= new MenuFrite();
        $Mfrit->setFrite($frite);
        $Mfrit->setQuantiteFrite($qt);
        $Mfrit->setMenu($this);
        $this->addMenuFrite($Mfrit);
    }
    //**METHODE PERMETTANT D AJOUTER UN BOISSON**

    /**
     * @return Collection<int, MenuTaille>
     */
    public function getMenutailles(): Collection
    {
        return $this->menutailles;
    }

    public function addMenutaille(MenuTaille $menutaille): self
    {
        if (!$this->menutailles->contains($menutaille)) {
            $this->menutailles->add($menutaille);
            $menutaille->setMenu($this);
        }

        return $this;
    }

    public function removeMenutaille(MenuTaille $menutaille): self
    {
        if ($this->menutailles->removeElement($menutaille)) {
            // set the owning side to null (unless already changed)
            if ($menutaille->getMenu() === $this) {
                $menutaille->setMenu(null);
            }
        }

        return $this;
    }

}
