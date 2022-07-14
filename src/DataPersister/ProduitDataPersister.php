<?php

namespace App\DataPersister;

use App\Entity\Menu;
use App\Entity\User;
use App\Entity\Frite;
use App\Entity\Burger;
use App\Entity\Boisson;
use App\Entity\Produit;
use App\Service\ServicePrix;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ProduitDataPersister implements ContextAwareDataPersisterInterface
{
    private ?TokenInterface $token;
    private ServicePrix $service;

    public function __construct(private EntityManagerInterface $entityManager, TokenStorageInterface $token,ServicePrix $service)
    {
        $this->entityManager = $entityManager;
        $this->token = $token->getToken();
        $this->service = $service;

    }
    
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Burger or $data instanceof Frite or $data instanceof Boisson or $data instanceof Menu;
    }
    /**
     * @param Produit $data
     */
    public function persist($data, array $context = [])
    {
        if($data instanceof Menu){

            if ($this->service->calculeprix($data)) {
                $data->setPrix($this->service->calculeprix($data));
                $data->setGestionaire($this->token->getUser());
                $this->entityManager->persist($data);
                $this->entityManager->flush();
            }
        }
        else {
            # code...
            
                $data->setGestionaire($this->token->getUser());
                $this->entityManager->persist($data);
                $this->entityManager->flush();
        }
        
       
    }
    /**
     * {@inheritdoc}
     **/
    public function remove($data, array $context = [])
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}