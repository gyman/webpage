<?php

namespace Dende\TestBundle\DataFixtures\ORM;

use Dende\TestBundle\DataFixtures\BaseFixture;
use Dende\SubscriptionBundle\Factory\SubscriptionFactory;
use Doctrine\Common\Persistence\ObjectManager;

class SubscriptionData extends BaseFixture
{
    /** @var SubscriptionFactory $factory */
    protected $factory;

    public function load(ObjectManager $manager)
    {
        $this->factory = new SubscriptionFactory();
        return parent::load($manager);
    }

    public function getOrder()
    {
        return 2;
    }

    public function insert($params)
    {
        $subscription = $this->factory->createSubscription($params["type"], array(
            "user"      => $this->getReference($params["user"]),
            "startDate" => new \DateTime($params["startDate"]),
            "endDate"   => new \DateTime($params["endDate"]),
        ));
        
        $this->manager->persist($subscription);
        $this->manager->flush();

        return $subscription;
    }
}
