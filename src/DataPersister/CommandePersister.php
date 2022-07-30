<?php

namespace App\DataPersister;
use App\Entity\Burger;
use App\Entity\Commande;
use App\Service\ServicePrix;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Json;
use Symfony\Component\HttpFoundation\JsonResponse;
use ProxyManager\Factory\RemoteObject\Adapter\JsonRpc;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CommandePersister implements ContextAwareDataPersisterInterface
{

private ?TokenInterface $token;
private  EntityManagerInterface $entityManager;
private ServicePrix $service;
    public function __construct( EntityManagerInterface $entityManager,ServicePrix $service, TokenStorageInterface $token)
    {
      $this->entityManager = $entityManager;
      $this->token = $token->getToken();
      $this->service = $service;

    }

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Commande ;
    }
    /**
     * @param Commande $data
     */
    public function persist($data, array $context = [])
    {
       
            $data->setPaiement(($this->service->CommandePrix($data)));
            $data->setClient($this->token->getUser());
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