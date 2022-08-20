<?php

namespace App\DataPersister;

use App\Entity\Livraison;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class LivraisonPersister implements ContextAwareDataPersisterInterface
{
 /**
     * @param User  $dataconnect
     */
    public function __construct( EntityManagerInterface $entityManager,TokenStorageInterface $tokenStorage)
    {
       
        $this->entityManager = $entityManager;
    }   
    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Livraison;
    }
    /**
     * @param Livraison $data
     */
    public function persist($data, array $context = [])
    {      
        
            $commande=$data->getCommandes();
            foreach ($commande as $elem) {
            $elem->setEtatCommande('En Cours De Livraison');
            }
            $this->entityManager->persist($data);
            $this->entityManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function remove($data, array $context = [])
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}