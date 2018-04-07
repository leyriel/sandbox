<?php
/**
 * Created by PhpStorm.
 * User: eric
 * Date: 06/04/18
 * Time: 14:41
 */

namespace App\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;


class UserAuthentificationService
{
    private $container;
    private $entityManager;

    public function __construct(ContainerInterface $_container, EntityManagerInterface $_entityManager)
    {
        $this->container = $_container;
        $this->entityManager = $_entityManager;
    }

    public function setEvent($event)
    {
        $tokenResponseContent = json_decode($event->getResponse()->getContent());
        $tokenRequestContent = json_decode($event->getRequest()->getContent());

        if (property_exists($tokenResponseContent, "error"))
        {
            return $event;
        }

        $this->authenticate($tokenRequestContent->username, $tokenRequestContent->password);

        return $event;
    }

    public function authenticate($username, $password)
    {
        //die('in the service UserAuthentification');
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $username]);

        dump($user);

        die;
    }

}