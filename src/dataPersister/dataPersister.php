<?php

namespace App\dataPersister;

use App\Entity\User;
use App\MailService\mailService;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
class dataPersister implements ContextAwareDataPersisterInterface
{

    public function __construct( EntityManagerInterface $entityManager, 
    UserPasswordHasherInterface $encoder,
    mailService $dataMail )
    {
        $this->encoder = $encoder;
        $this->entityManager = $entityManager;
        $this->dataMail=$dataMail;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof User;
    }

    /**
     * @param User $data
     */
    public function persist($data, array $context = [])
    {
        if ($data->getPlainPassword()) {
            $password = $this->encoder->hashPassword($data,$data->getPlainPassword());
            $data->setPassword($password);
            $data->eraseCredentials();
            $this->entityManager->persist($data);
            
            $this->entityManager->flush();
            $this->dataMail->envoiMail($data);
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