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
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
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

    public function auth($event)
    {
        $tokenResponseContent = json_decode($event->getResponse()->getContent());
        $tokenRequestContent  = json_decode($event->getRequest()->getContent());
        $userManager          = $this->container->get('fos_user.user_manager');

        if (property_exists($tokenResponseContent, "error"))
        {
            return $event;
        }

        $authenticate = $this->authenticate($tokenRequestContent->username, $tokenRequestContent->password, $event);

        $arrayContent = json_decode($authenticate->getResponse()->getContent());

        $arrayContent->userId = $userManager->findUserByUsername($this->container->get('security.token_storage')->getToken()->getUser())->getId();

        $authenticate->getResponse()->setContent(json_encode($arrayContent));

        return $authenticate;
    }

    public function authenticate($username, $password, $event = null)
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['username' => $username]);
        $factory = $this->container->get('security.encoder_factory');

        if (is_null($user))
        {
            $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $username]);
        }

        if(is_null($user))
        {
            $event->setResponse(new Response(json_encode('User not found.'), Response::HTTP_UNAUTHORIZED, array('Content-type' => 'application/json')));
            return $event;
        }

        $encoder = $factory->getEncoder($user);
        $salt = $user->getSalt();

        if(!$encoder->isPasswordValid($user->getPassword(), $password, $salt)) {

            $event->setResponse(new Response(json_encode('Username or Password not valid.'), Response::HTTP_UNAUTHORIZED, array('Content-type' => 'application/json')));
            return $event;
        }

        $token = new UsernamePasswordToken($user, null, 'oauth_token', $user->getRoles());


        $this->container->get('security.token_storage')->setToken($token);
        $this->container->get('session')->set('_security_oauth_token', serialize($token));

        $loginEvent = new InteractiveLoginEvent($event->getRequest(), $token);
        $this->container->get("event_dispatcher")->dispatch("security.interactive_login", $loginEvent);

        return $event;
    }
}