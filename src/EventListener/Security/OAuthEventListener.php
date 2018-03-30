<?php
/**
 * Created by PhpStorm.
 * User: eric
 * Date: 30/03/18
 * Time: 16:12
 */

namespace App\EventListener\Security;

use FOS\OAuthServerBundle\Event\OAuthEvent;


class OAuthEventListener
{
    public function onPreAuthorizationProcess(OAuthEvent $event)
    {
        die('pre');
        if ($user = $this->getUser($event)) {
            $event->setAuthorizedClient(
                $user->isAuthorizedClient($event->getClient())
            );
        }
    }

    public function onPostAuthorizationProcess(OAuthEvent $event)
    {
        die('post');
        if ($event->isAuthorizedClient()) {
            if (null !== $client = $event->getClient()) {
                $user = $this->getUser($event);
                $user->addClient($client);
                $user->save();
            }
        }
    }

    protected function getUser(OAuthEvent $event)
    {
        return UserQuery::create()
            ->filterByUsername($event->getUser()->getUsername())
            ->findOne();
    }
}