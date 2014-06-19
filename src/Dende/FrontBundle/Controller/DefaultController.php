<?php

namespace Dende\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/",name="frontpage_index")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
    /**
     * @Route("/error",name="frontpage_error")
     * @Template()
     */
    public function errorAction()
    {
        if(1==1) {
            throw new \Exception("some error");
        }
        
        return array();
    }
}
