<?php

namespace Dende\TestBundle\DataFixtures\ORM;

use Dende\TestBundle\DataFixtures\BaseFixture;
use Dende\AccountBundle\Entity\User;

class UserData extends BaseFixture
{
    public function getOrder()
    {
        return 1;
    }

    public function insert($params)
    {
        $user = new User();
        $user->setUsername($params["username"]);
        $user->setEmail($params["email"]);
        $user->setRoles($params["roles"]);
        $user->setPlainPassword($params["plainPassword"]);
        $user->setEnabled($params["enabled"]);
        
        $this->manager->persist($user);
        $this->manager->flush();

        return $user;
    }
}
