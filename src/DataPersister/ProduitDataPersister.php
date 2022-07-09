<?php

namespace App\DataPersister;

use App\Entity\User;
use App\Entity\Frite;
use App\Entity\Burger;
use App\Entity\Boisson;
use App\Entity\Produit;
use App\Entity\User as U;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ProduitDataPersister implements ContextAwareDataPersisterInterface
{
    // private ?TokenInterface $token;
    
    public function __construct(private EntityManagerInterface $entityManager, TokenStorageInterface $token)
    {
        $this->entityManager = $entityManager;
        $this->token = $token;
        
    }
    
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Burger or $data instanceof Frite or $data instanceof Boisson;
    }
    /**
     * @param Produit $data
     */
    public function persist($data, array $context = [])
    {
        // dd($data);
        $data->setGestionaire($this->token->getToken()->getUser());
        $this->entityManager->persist($data);
        $this->entityManager->flush();
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