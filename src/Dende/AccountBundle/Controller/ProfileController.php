<?php

namespace Dende\AccountBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/profile")
 */
class ProfileController extends Controller
{
    /**
     * @Route("/", name="profile_dashboard")
     * @Template()
     */
    public function indexAction()
    {
        return array(
                // ...
            );    }

    /**
     * @Route("/orders", name="profile_orders")
     * @Template()
     */
    public function ordersAction()
    {
        $paginator = $this->get("knp_paginator");
        $pagination = $paginator->paginate(
            $this->getUser()->getSubscriptions(),
            $this->get('request')->query->get('page', 1),
            10
        );
        
        return array(
            "pagination" => $pagination
        );
    }

    /**
     * @Route("/account", name="profile_account")
     * @Template()
     */
    public function accountAction()
    {
        return array(
                // ...
            );    }
    /**
     * @Route("/invoices", name="profile_invoices")
     * @Template()
     */
    public function invoicesAction()
    {
        return array(
                // ...
            );    }

}
