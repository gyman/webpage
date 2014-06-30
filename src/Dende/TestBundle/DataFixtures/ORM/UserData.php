<?php

namespace Dende\TestBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Dende\AccountBundle\Entity\User;
use Symfony\Component\Yaml\Yaml;

class UserData extends AbstractFixture implements OrderedFixtureInterface
{

    private $manager;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        
        $value = Yaml::parse(file_get_contents(__DIR__.'/../Yaml/users.yml'));
        
        foreach ($value as $key => $params) {
            $object = $this->insert($params);
            $this->addReference($key, $object);
        }
    }

    public function getOrder()
    {
        return 1;
    }

    private function insert($params)
    {
        $user = new User();
        $user->setUsername($params["username"]);
        $user->setEmail($params["email"]);
        $user->setPlainPassword($params["plainPassword"]);
        $user->setEnabled($params["enabled"]);
        
        $this->manager->persist($user);
        $this->manager->flush();

        return $user;
    }
}
