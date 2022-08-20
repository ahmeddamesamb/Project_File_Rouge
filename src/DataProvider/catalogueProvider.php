<?php
namespace App\DataProvider;

use App\Entity\Catalogue;
use Doctrine\Common\Annotations\Reader;
use phpDocumentor\Reflection\Types\Boolean;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use App\Repository\BurgerRepository;
use App\Repository\MenuRepository;

class catalogueProvider implements ContextAwareCollectionDataProviderInterface,RestrictedDataProviderInterface
{
  
    
    public function __construct(MenuRepository $menu,BurgerRepository $burger)
    {
        $this->menu = $menu;
        $this->burger = $burger;
        
    }
    public function getCollection(string $resourceClass, ?string $operationName = null, array $context = [])
    {
        $produit=[];
    

        foreach($this->menu->findAll() as $menu )
        {
            $produit[]=$menu;

        }
        foreach($this->burger->findAll() as $burger )
        {
            $produit[]=$burger;
        }
        return $produit;
    }

    public function supports(string $resourceClass,string $operationName = null, array $context = []):Bool
    {    
        return $resourceClass===Catalogue::class;
    }

} 