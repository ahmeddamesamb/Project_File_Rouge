<?php

namespace App\DataPersister;

use App\Entity\Menu;
use App\Service\ServicePrix;

use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Commande;

class CommandePersister implements ContextAwareDataPersisterInterface
{
private  EntityManagerInterface $entityManager;
private ServicePrix $service;
    public function __construct( EntityManagerInterface $entityManager,ServicePrix $service)
    {
      $this->entityManager = $entityManager;
      $this->service = $service;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($sa, array $context = []): bool
    {
        return $sa instanceof Commande;
    }

    /**
     * @param Commande $data
     */
    public function persist($sa, array $context = [])
    {
        
        // if ($this->service->CommandePrix($sa)) {     
        //     $sa->getLigneCommandes()->setPrix($this->service->CommandePrix($sa));
            $this->entityManager->persist($sa);
            $this->entityManager->flush();
        // }

    }

    /**
     * {@inheritdoc}
     */
    public function remove($sa, array $context = [])
    {
        $this->entityManager->remove($sa);
        $this->entityManager->flush();
    }
}