<?php
/**
 * Created by PhpStorm.
 * User: eric
 * Date: 23/02/18
 * Time: 23:27
 */

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;


/**
 * Class AuthenticationEntryPoint
 * Returns a 401 if the user is not logged in instead of redirecting to the login page
 *
 * @author Nicolas Macherey <nicolas.macherey@gmail.com>
 */
class TokenAuthenticator implements AuthenticationEntryPointInterface
{
    /**
     * {@inheritdoc}
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $response = new Response('', 401);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}