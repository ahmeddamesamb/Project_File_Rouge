<?php

namespace App\DataPersister;

use App\Entity\User;
use App\Entity\Client;
use App\Entity\Livreur;
use App\MailService\mailService;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Gestionaire;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class dataPersister implements ContextAwareDataPersisterInterface
{
    
    public function __construct( EntityManagerInterface $entityManager, 
    UserPasswordHasherInterface $encoder,
    mailService $dataMail, TokenStorageInterface $token)
    {
        $this->encoder = $encoder;
        $this->entityManager = $entityManager;
        $this->dataMail=$dataMail;
        $this->token = $token;
        
    }
    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Livreur or $data instanceof Client or $data instanceof Gestionaire;
    }

    /**
     * @param User $data
     */
    public function persist($data, array $context = [])
    {
        // dd($data);
        if ($data->getPlainPassword()) {
            $password = $this->encoder->hashPassword($data,$data->getPlainPassword());
            $data->setPassword($password);
            $data->eraseCredentials();    
            $this->entityManager->persist($data);
            $this->entityManager->flush();
            $this->dataMail->envoiMail($data);
        }
        dd('imposible bjfkq');
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