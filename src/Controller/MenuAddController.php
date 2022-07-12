<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Entity\MenuBurger;
use App\Repository\BoissonRepository;
use App\Repository\BurgerRepository;
use App\Repository\FriteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MenuAddController extends AbstractController
{

    public function __invoke (Request $request, EntityManagerInterface $entityManager,
    FriteRepository $fr,BoissonRepository $boi,BurgerRepository $bur)
    {
        $content = json_decode($request->getContent());
        if (!isset($content->nom)&& ($content->image)) {
           return $this->json('Nom et image Obligatoire Pour le menu',400);       
        }
        $plat= new Menu();
        $plat->setNom($content->nom);
        $plat->setImage($content->image);
        // *****************************BURGERS*****************************************//

        foreach ($content->Burgers as $b) {
            # code...
            $burger=$bur->find($b->burger);
            if($burger)
            {
                $plat->addBurger($burger,$b->qt);
            }
            // ********************************BOISSON**************************************//
        
             foreach ($content->boissons as $bo) {
                 # code...
                 $boisson=$boi->find($b->boisson);
                 if($boisson)
                 {
                     $plat->addBoisson($boisson,$bo->qt);
                 }
             }
             
             
         }
        
         // ******************************FRITES****************************************//
         
       foreach ($content->frites as $f) {
           # code...
        $frite=$fr->find($f->frite);
        if($frite)
        {
            $plat->addFrite($frite,$f->qt);
        }
    }
    $entityManager->persist($plat);
             $entityManager->flush();
             return  $this->json('Succes MMM',201);
}
}
