<?php

namespace Dende\AccountBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function navigation(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
         
        $menu->setCurrent(
            $this->container->get('request')->getRequestUri()
        );
        
        $menu->addChild('profile_menu.label.dashboard', array('route' => 'profile_dashboard', "extras" => array("icon" => 'fa-bar-chart-o')))
            ->setExtra('translation_domain', 'AccountBundle');
        
        $menu->addChild('profile_menu.label.account', array('route' => 'profile_account', "extras" => array("icon" => 'fa-user')))
            ->setExtra('translation_domain', 'AccountBundle');

        $menu->addChild('profile_menu.label.orders', array('route' => 'profile_orders', "extras" => array("icon" => 'fa-shopping-cart')))
            ->setExtra('translation_domain', 'AccountBundle');
        
        $menu->addChild('profile_menu.label.invoice_data', array('route' => 'profile_invoice_data', "extras" => array("icon" => 'fa-envelope-o')))
            ->setExtra('translation_domain', 'AccountBundle');
        
        $menu->addChild('profile_menu.label.buy_subscription', array('route' => 'profile_orders', "extras" => array("icon" => 'fa-plus')))
            ->setExtra('translation_domain', 'AccountBundle');
        return $menu;
    }
}
