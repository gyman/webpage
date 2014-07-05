<?php

namespace Dende\AccountBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * @UniqueEntity(
 *     fields={"email"},
 *     message="user.email_exists"
 * )
 * @UniqueEntity(
 *     fields={"username"},
 *     message="user.username_exists"
 * )
 */
class User extends BaseUser
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    
    
    /**
     * @ORM\OneToMany(
     *  targetEntity="Dende\SubscriptionBundle\Entity\SubscriptionBase",
     *  mappedBy="user", cascade={"remove"}, orphanRemoval=true
     * )
     */
    protected $subscriptions;

    public function __construct()
    {
        parent::__construct();
        
        $this->setSubscriptions(new ArrayCollection());
    }

    public function getSubscriptions()
    {
        return $this->subscriptions;
    }

    public function setSubscriptions($subscriptions)
    {
        $this->subscriptions = $subscriptions;
        return $this;
    }
}
