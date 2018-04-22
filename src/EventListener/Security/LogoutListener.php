<?php
/**
 * Created by PhpStorm.
 * User: eric
 * Date: 07/04/18
 * Time: 20:39
 */

namespace App\EventListener\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;


class LogoutListener implements LogoutSuccessHandlerInterface
{
    private $container;
    private $entityManager;

    public function __construct(ContainerInterface $_container, EntityManagerInterface $_entityManager)
    {
        $this->container = $_container;
        $this->entityManager = $_entityManager;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function onLogoutSuccess(Request $request)
    {
        // Remove Oauth Token here;

        $token = new AnonymousToken("main", 'anon.');
        $this->container->get('security.token_storage')->setToken($token);
        $request->getSession()->invalidate();

        return new Response(json_encode('User logout successful'), Response::HTTP_OK, array('Content-type' => 'application/json'));
    }
}