<?php

namespace Dende\FrontBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Blank;
use Symfony\Component\Validator\Constraints\Length;

class ContactType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('email',"email",array(
                    "label" => "Adres email",
                    "constraints" => [
                        new Email([
                           "message" => "Nieprawidłowy adres email." 
                        ])
                    ],
                    "error_bubbling" => true
                ))
                ->add('message',"textarea",array(
                    "label" => "Wiadomość",
                    "constraints" => array(
                        new Length([
                            "min" => 10,
                            "minMessage" => "Wiadomość jest zbyt krótka, powinna zawierać conajmniej {{ limit }} znaków",
                            "max" => 1000,
                            "maxMessage" => "Wiadomość jest zbyt długa, powinna zawierać maksymalnie {{ limit }} znaków",
                        ])
                    ),
                    "error_bubbling" => true
                ))
                ->add('submit',"submit")
        ;
    }

    public function getName() {
        return 'contact_form';
    }

}
