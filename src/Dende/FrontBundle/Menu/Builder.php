<?php

namespace Dende\FrontBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{

    private $navigationItems = [
        "menu.label.description" => "frontpage_index",
        "menu.label.blog" => "frontpage_index",
        "menu.label.demo_app" => "frontpage_index",
        "menu.label.download" => "frontpage_download",
        "menu.label.pricing" => "frontpage_pricing",
        "menu.label.contact" => "frontpage_contact",
        "menu.label.login" => "fos_user_security_login",
    ];
    
    public function navigation(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
 
        $menu->setChildrenAttributes(array('class' => 'nav navbar-nav navbar'));
        
        $menu->addChild('menu.label.description', array('route' => "frontpage_index"))
            ->setExtra('translation_domain', 'FrontBundle');
        
//        $menu->addChild("menu.label.blog", array('route' => "frontpage_index"))
//            ->setExtra('translation_domain', 'FrontBundle');
        
        $menu->addChild("menu.label.demo_app", array('uri' => "http://app.gyman.pl"))
            ->setExtra('translation_domain', 'FrontBundle');
        
//        $menu->addChild('menu.label.download', array('route' => "frontpage_download"))
//            ->setExtra('translation_domain', 'FrontBundle');
        
        $menu->addChild("menu.label.contact", array('route' => "frontpage_contact"))
            ->setExtra('translation_domain', 'FrontBundle');
        
        if($this->isLogged()) {
            $menu->addChild("menu.label.your_account", array('route' => "fos_user_profile_show"))
                ->setExtra('translation_domain', 'FrontBundle');
        } else {
            $menu->addChild("menu.label.pricing", array('route' => "frontpage_pricing"))
                ->setExtra('translation_domain', 'FrontBundle');
        }
        
        if($this->isLogged()) {
            $menu->addChild("menu.label.logout", array('route' => "fos_user_security_logout"))
                ->setExtra('translation_domain', 'FrontBundle');
        } else {
            $menu->addChild("menu.label.login", array('route' => "fos_user_security_login"))
                ->setExtra('translation_domain', 'FrontBundle');
        }
        
        return $menu;
    }
    
    private function isLogged()
    {
        $securityContext = $this->container->get('security.context');
        return $securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED');
    }
    
}
