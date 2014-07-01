<?php

namespace Dende\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Dende\FrontBundle\Form\ContactType;

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
        if (1 == 1) {
            throw new \Exception("some error");
        }

        return array();
    }

    /**
     * @Route("/download",name="frontpage_download")
     * @Template()
     */
    public function downloadAction(Request $request)
    {
        return array(
            "download_link" => $this->container->getParameter("download_link"),
            "github_link" => $this->container->getParameter("github_link")
        );
    }

    /**
     * @Route("/pricing",name="frontpage_pricing")
     * @Template()
     */
    public function pricingAction(Request $request)
    {
        return array();
    }
    
    /**
     * @Route("/contact",name="frontpage_contact")
     * @Method({"GET","POST"})
     * @Template()
     */
    public function contactAction(Request $request)
    {
        $form = $this->createForm(new ContactType);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $this->get('session')->getFlashBag()->add(
                    'notice',
                    $this->get("translator")->trans("contact.thank_you_message")
                );
                
                $mailer = $this->get("mailer.contact");
                $mailer->setParameters(array(
                    "message" => $form->get("message")->getData(),
                    "email" => $form->get("email")->getData()
                ));
                $mailer->setFrom(
                    $form->get("email")->getData()
                );
                $mailer->sendMail();
            }
        }
        
        return array(
            "form" => $form->createView()
        );
    }
}
