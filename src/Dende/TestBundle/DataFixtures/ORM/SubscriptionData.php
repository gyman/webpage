<?php

namespace Dende\TestBundle\DataFixtures\ORM;

use Dende\TestBundle\DataFixtures\BaseFixture;
use Dende\SubscriptionBundle\Entity\SubscriptionFactory;

class SubscriptionData extends BaseFixture
{

    /**
     *
     * @var SubscriptionFactory $factory 
     */
    protected $factory;
    protected $fixtureFile = '/../Yaml/subscriptions.yml';

    public function load(\Doctrine\Common\Persistence\ObjectManager $manager)
    {
        $this->factory = new SubscriptionFactory();
        return parent::load($manager);
    }

    public function getOrder()
    {
        return 2;
    }

    private function insert($params)
    {
        $subscription = $this->factory->createSubscription($params["type"], array(
            "user"      => $this->getReference($params["user"]),
            "startDate" => new \DateTime($params["startDate"]),
            "endDate"   => new \DateTime($params["endDate"]),
        ));

        return $subscription;
    }
}
