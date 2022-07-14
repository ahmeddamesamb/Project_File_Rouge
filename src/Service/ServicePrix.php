<?php
namespace App\Service;
use App\Entity\Menu;
use App\Entity\Commande;
use App\Entity\MenuFrite;

class ServicePrix{
    /**
     * @param Menu $menu
     */
    public function calculeprix($menu) {
        $prix=0;

        foreach ($menu->getMenuBurgers() as $menuBurgers){
            $prix+=$menuBurgers->getBurger()->getPrix()*$menuBurgers->getQuantiteBurger();
        }
        foreach ($menu->getMenuFrites() as $menuFrites){
            $prix+=$menuFrites->getFrite()->getPrix()*$menuFrites->getQuantiteFrite();
        }
           foreach ($menu->getMenuBoissons() as $menuBoissons){
            $prix+=$menuBoissons->getBoisson()->getPrix()*$menuBoissons->getQuantiteBoisson();
           }
        return $prix;
    }

      /**
     * @param Commande $commande
     */
        public function CommandePrix($commande) {
            $prix=0;
                foreach ($commande->getLigneCommandes() as $menuFrites){
                    $this->prix=$menuFrites->getProduit()->getPrix()*($menuFrites->getQuantite());
                    
                }
                
                foreach ($commande->getLigneCommandes() as $menuBoissons){
                    $this->prix=$menuBoissons->getProduit()->getPrix()*($menuBoissons->getQuantite());
                }
                
                foreach ($commande->getLigneCommandes() as $menuBurgers){
                    $this->prix=$menuBurgers->getProduit()->getPrix()*($menuBurgers->getQuantite());
                    
                }
                return $this->prix;
           
        }

}
