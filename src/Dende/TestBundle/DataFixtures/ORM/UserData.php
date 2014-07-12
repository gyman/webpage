<?php

namespace Dende\TestBundle\DataFixtures\ORM;

use Dende\TestBundle\DataFixtures\BaseFixture;
use Dende\AccountBundle\Entity\User;
use Dende\AccountBundle\Model\InvoiceData;

class UserData extends BaseFixture
{
    public function getOrder()
    {
        return 1;
    }

    public function insert($params)
    {
        $invoiceData = new InvoiceData;
        $invoiceData->setCompanyName($params["invoiceData"]["companyName"]);
        $invoiceData->setNip($params["invoiceData"]["nip"]);
        $invoiceData->setStreet($params["invoiceData"]["street"]);
        $invoiceData->setZipcode($params["invoiceData"]["zipcode"]);
        $invoiceData->setCity($params["invoiceData"]["city"]);
        $invoiceData->setCountry($params["invoiceData"]["country"]);
        
        $user = new User();
        $user->setFirstname($params["firstname"]);
        $user->setLastname($params["lastname"]);
        $user->setUsername($params["username"]);
        $user->setEmail($params["email"]);
        $user->setRoles($params["roles"]);
        $user->setPlainPassword($params["plainPassword"]);
        $user->setEnabled($params["enabled"]);
        $user->setInvoiceData($invoiceData);
                
        $this->manager->persist($user);
        $this->manager->flush();

        return $user;
    }
}
