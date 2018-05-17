<?php
/**
 * Created by PhpStorm.
 * User: eric
 * Date: 07/04/18
 * Time: 21:19
 */

namespace App\EventListener\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpFoundation\Response;


class LoginListener
{
    private $container;
    private $entityManager;

    public function __construct(ContainerInterface $_container, EntityManagerInterface $_entityManager)
    {
        $this->container = $_container;
        $this->entityManager = $_entityManager;
    }

    public function onAuthenticationSuccess(InteractiveLoginEvent $event)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->findUserByUsername($this->container->get('security.token_storage')
            ->getToken()
            ->getUser());
    }

}