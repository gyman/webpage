<?php

namespace Dende\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
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
        if (1 == 1)
        {
            throw new \Exception("some error");
        }

        return array();
    }

    /**
     * @Route("/contact",name="frontpage_contact")
     * @Template()
     */
    public function contactAction(Request $request)
    {
        $form = $this->createForm(new ContactType);

        if ($request->getMethod() == 'POST')
        {
            $form->handleRequest($request);

            if ($form->isValid())
            {
                $this->get('session')->getFlashBag()->add(
                    'notice',
                    'Dziękujemy! Twoja wiadomość zostanie zaraz przeczytana i odpiszemy tak szybko jak się nam uda :)'
                );
                
                /**
                 * @var $mailer \Swift_Mailer
                 */
                $mailer = $this->get("mailer");
                $message = $mailer->createMessage();
                $message->setSubject("Formularz kontaktowy - GyMan.pl")
                    ->setTo("some@email.com")
                    ->setFrom($form->get("email")->getData())
                    ->setBody(
                        $this->renderView("::contactMessage.html.twig",[
                            "message" => $form->get("message")->getData(),
                            "email" => $form->get("email")->getData()
                        ]),
                        'text/html'
                    );
                
                $mailer->send($message);
            }
        }
        
        return array(
            "form" => $form->createView()
        );
    }

}
