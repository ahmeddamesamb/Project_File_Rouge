<?php

namespace App\DataPersister;

use App\Entity\Menu;
use App\Service\ServicePrix;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class MenuPersister implements ContextAwareDataPersisterInterface
{
private  EntityManagerInterface $entityManager;
private ServicePrix $service;
    public function __construct( EntityManagerInterface $entityManager,ServicePrix $service, TokenStorageInterface $token)
    {
      $this->entityManager = $entityManager;
      $this->service = $service;

    }

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Menu;
    }

    /**
     * @param Menu $data
     */
    public function persist($data, array $context = [])
    {

    
        if ($this->service->calculeprix($data)) {
            $data->setPrix($this->service->calculeprix($data));
            $this->entityManager->persist($data);
            $this->entityManager->flush();
        }
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