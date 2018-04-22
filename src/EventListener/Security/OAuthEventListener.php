<?php
/**
 * Created by PhpStorm.
 * User: eric
 * Date: 30/03/18
 * Time: 16:12
 */

namespace App\EventListener\Security;

use App\Service\UserAuthentificationService;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class OAuthEventListener
{
    private $authentificator;

    public function __construct(UserAuthentificationService $_authentificationService)
    {
        $this->authentificator = $_authentificationService;
    }

    public function onPreAuthorizationProcess(FilterResponseEvent $event){}

    public function onPostAuthorizationProcess(FilterResponseEvent $event)
    {
        $uri = $event->getRequest()->getRequestUri();

        if ($uri == "/oauth/v2/token")
        {
            return $this->authentificator->setEvent($event);
        }

        return $event;
    }

}