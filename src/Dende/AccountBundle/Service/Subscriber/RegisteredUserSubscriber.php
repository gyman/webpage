<?php

namespace Dende\AccountBundle\Service\Subscriber;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Event\FormEvent;
use \Symfony\Component\Routing\Router;

class RegisteredUserSubscriber implements EventSubscriberInterface
{

    /**
     * @var Router $router
     */
    private $router;

    /**
     *
     * @return type
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     *
     * @param \Symfony\Component\Routing\Router $router
     * @return \Dende\AccountBundle\Service\Subscriber\RegisteredUserSubscriber
     */
    public function setRouter(Router $router)
    {
        $this->router = $router;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationCompleted',
        );
    }

    public function onRegistrationCompleted(FormEvent $event)
    {
        $url = $this->router->generate('profile_dashboard');
        $event->setResponse(new RedirectResponse($url));
    }
}
