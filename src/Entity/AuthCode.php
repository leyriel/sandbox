<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\OAuthServerBundle\Entity\AuthCode as BaseAuthCode;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AuthCodeRepository")
 */
class AuthCode extends BaseAuthCode
{
    protected $id;
    protected $client;
    protected $customer;
}
