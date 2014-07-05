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
        return array(
                "data" => array()
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
