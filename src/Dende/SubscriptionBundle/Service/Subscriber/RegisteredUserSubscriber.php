<?php

namespace Dende\SubscriptionBundle\Service\Subscriber;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use Dende\SubscriptionBundle\Entity\SubscriptionFactory;

class RegisteredUserSubscriber implements EventSubscriberInterface
{

    /**
     * @var EntityManager $entityManager
     */
    private $entityManager;

    /**
     * @var Session $session
     */
    private $session;

    /**
     *
     * @var SubscriptionFactory $subscriptionFactory
     */
    private $subscriptionFactory;

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @return \Dende\SubscriptionBundle\Service\Subscriber\RegisteredUserSubscriber
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     * @return Session
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Session\Session $session
     * @return \Dende\SubscriptionBundle\Service\Subscriber\RegisteredUserSubscriber
     */
    public function setSession(Session $session)
    {
        $this->session = $session;
        return $this;
    }

    /**
     * @return SubscriptionFactory
     */
    public function getSubscriptionFactory()
    {
        return $this->subscriptionFactory;
    }

    /**
     * @param \Dende\SubscriptionBundle\Entity\SubscriptionFactory $subscriptionFactory
     * @return \Dende\SubscriptionBundle\Service\Subscriber\RegisteredUserSubscriber
     */
    public function setSubscriptionFactory(SubscriptionFactory $subscriptionFactory)
    {
        $this->subscriptionFactory = $subscriptionFactory;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_COMPLETED => 'onRegistrationCompleted',
        );
    }

    public function onRegistrationCompleted(FilterUserResponseEvent $event)
    {
        $user = $event->getUser();
        $subscriptionType = $this->session->get("subscription_type");

        $subscription = $this->subscriptionFactory->createSubscription($subscriptionType, array(
            "user" => $user,
            "startDate" => new \DateTime,
            "endDate" => new \DateTime("+1 month"),
        ));

        $this->entityManager->persist($subscription);
        $this->entityManager->flush();
    }
}
