<?php

namespace Dende\AccountBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Dende\TestBundle\Tests\BaseTest;

class DefaultControllerTest extends BaseTest
{
    public function testLogin()
    {
        $this->clientIsSettedUp();
        $this->getPage("/login");
        $this->assertPageResponseCode(200);
        $this->assertPageContainsText("account.login.header_link_login");
    }
}
