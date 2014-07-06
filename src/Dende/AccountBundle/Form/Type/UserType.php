<?php

namespace Dende\AccountBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;

class UserType extends BaseType
{

    private $class = 'Dende\AccountBundle\Entity\User';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname', null, array('label' => 'form.label.firstname'));
        $builder->add('lastname', null, array('label' => 'form.label.lastname'));
        parent::buildForm($builder, $options);
    }

    public function __construct($class)
    {
        $this->class = $class;
        return parent::__construct($this->class);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dende_user_profile';
    }
}
