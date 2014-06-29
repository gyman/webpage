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
        
        foreach($this->navigationItems as $label => $route) {
            $menu->addChild($label, array('route' => $route))
                ->setExtra('translation_domain', 'FrontBundle');
        }
        
        return $menu;
    }
    
}
