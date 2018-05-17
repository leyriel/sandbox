<?php
/**
 * Created by PhpStorm.
 * User: eric
 * Date: 26/03/18
 * Time: 14:11
 */

namespace App\Controller;

use App\Entity\User;


class UserSpecial
{
    public function __invoke(User $data): User
    {
        dump($data);

        

        return $data;
    }

}