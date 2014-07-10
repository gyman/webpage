<?php

namespace Dende\AccountBundle\Service\Subscriber;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\Session\Session;

class UpdatedProfileSubscriber implements EventSubscriberInterface
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
     * @return Router
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
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
            FOSUserEvents::PROFILE_EDIT_COMPLETED => 'onProfileEditCompleted',
            FOSUserEvents::PROFILE_EDIT_SUCCESS   => 'onProfileEditSuccess',
            FOSUserEvents::CHANGE_PASSWORD_COMPLETED => 'onResettingCompleted',
            FOSUserEvents::CHANGE_PASSWORD_SUCCESS => 'onResettingSuccess',
        );
    }

    public function onProfileEditSuccess(FormEvent $event)
    {
        $this->setFlash(
            'notice',
            'user.notice.profile_updated_succesfuly'
        );
    }

    public function onProfileEditCompleted(FilterUserResponseEvent $event)
    {
        $this->redirectToDashboard($event);
    }

    public function onRessetingSuccess(FilterUserResponseEvent $event)
    {
        $this->redirectToDashboard($event);
    }
    public function onRessetingCompleted(FilterUserResponseEvent $event)
    {
        $this->redirectToDashboard($event);
        $this->setFlash(
            'notice',
            'user.notice.password_resetted_succesfuly'
        );
    }
    
    private function redirectToDashboard($event)
    {
        $url = $this->router->generate('profile_dashboard');
        $event->getResponse()->setTargetUrl($url);
    }
    
    private function setFlash($type, $message)
    {
        $this->session->getFlashBag()->add($type, $message);
    }
    
}
