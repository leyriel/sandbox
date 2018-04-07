<?php
/**
 * Created by PhpStorm.
 * User: eric
 * Date: 28/02/18
 * Time: 16:46
 */

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class EntryPoint implements AuthenticationEntryPointInterface
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    public function start(Request $request, AuthenticationException $authException = null)
    {
        $oAuth = $this->container->get('OAuth2\OAuth2');

        $response = new Response(
            '{"error":{"code":'.Response::HTTP_UNAUTHORIZED.',"message":"Hey, Get out bro..."}}',
            Response::HTTP_UNAUTHORIZED,
            array('Content-Type'=>'application/json'));
        return $response;
    }

}