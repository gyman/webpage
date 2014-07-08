<?php

namespace Dende\AccountBundle\Service\Subscriber;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\Session\Session;

class RegisteredUserSubscriber implements EventSubscriberInterface
{

    /**
     * @var Router $router
     */
    private $router;

    /**
     * @var Session $session
     */
    private $session;

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

    public function getSession()
    {
        return $this->session;
    }

    public function setSession(Session $session)
    {
        $this->session = $session;
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
        
        $this->session->getFlashBag()->add(
            'notice',
            'user.notice.profile_registered_succesfuly'
        );
    }
}
