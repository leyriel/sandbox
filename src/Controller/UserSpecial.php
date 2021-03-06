<?php
/**
 * Created by PhpStorm.
 * User: eric
 * Date: 26/03/18
 * Time: 14:11
 */

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManagerInterface;

class UserSpecial
{

    private $container;
    private $entityManager;

    public function __construct(ContainerInterface $_container, EntityManagerInterface $_entityManager)
    {
        $this->container = $_container;
        $this->entityManager = $_entityManager;
    }

    public function __invoke(User $data)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->findUserByUsername($this->container->get('security.token_storage')
            ->getToken()
            ->getUser());

        return $user;
    }

}