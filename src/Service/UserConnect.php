<?php
namespace App\Service;
use Psr\Container\ContainerInterface;
use Symfony\Component\Security\Core\Security;

class UserConnect 
{
    private $security;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function someMethod()
    {
        // returns User object or null if not authenticated
        $user = $this->security->getUser();
        $token = $this->security->getToken();
    }
}