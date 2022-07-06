<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Produit;
use App\Entity\User;
use App\Entity\User as U;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ProduitDataPersister implements ContextAwareDataPersisterInterface
{

    private $usersConnected;
    private ?TokenInterface $token;

    public function __construct(private EntityManagerInterface $entityManager, TokenStorageInterface $token)
    {
        $this->entityManager = $entityManager;
        $this->user = $token->getToken();
    }

    public function supports($data, array $context = []): bool
    {
        return false;
    }

    /**
     * @param Produit $data
     */
    public function persist($data, array $context = [])
    {
        dd($data);
        $data->setGestionaire($this->token->getUser());
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