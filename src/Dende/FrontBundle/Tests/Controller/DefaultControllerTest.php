<?php

namespace Dende\FrontBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Dende\TestBundle\Tests\BaseTest;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class DefaultControllerTest extends BaseTest
{

    public function testIndex()
    {
        $this->clientIsSettedUp();
        $this->getPage("/");
        $this->assertPageResponseCode(200);
        $this->assertPageContainsText("frontpage.captions.in_short");
    }

    public function testDemoApp()
    {
        $this->clientIsSettedUp();
        $this->getPage("/");
        $this->assertPageResponseCode(200);

        $link = $this->crawler->selectLink('menu.label.demo_app')->link();

        $this->client->click($link);
        $this->assertPageResponseCode(200);
    }

    public function testLogin()
    {
        $this->clientIsSettedUp();
        $this->fixturesAreLoaded();

        $this->getPage("/login");
        $this->assertPageResponseCode(200);

        $this->loginFormWasSubmitted('uirapuru', '1234');
        $this->assertPageContainsText("Bad credentials");

        $this->loginFormWasSubmitted('uirapuru123', '1234');
        $this->assertPageContainsText("Bad credentials");

        $this->loginFormWasSubmitted('uirapuru', '123');
        $this->assertPageResponseCode(200);
    }

    public function testRegister()
    {
        $this->clientIsSettedUp();
        $this->fixturesAreLoaded();

        $this->getPage("/register");
        $this->assertPageResponseCode(200);

        $this->registerFormWasSubmitted('uirapuru345', '123', '123', 'uirapuru345@tlen.pl');
        $this->assertPageResponseCode(200);
        $this->assertPageContainsText('registration.confirmed');
    }

    /**
     * @dataProvider testRegisterDataProvider
     */
    public function testRegisterErrors($username, $password1, $password2, $email, $notice)
    {
        $this->clientIsSettedUp();
        $this->fixturesAreLoaded();

        $this->getPage("/register");
        $this->assertPageResponseCode(200);

        $this->registerFormWasSubmitted($username, $password1, $password2, $email);
        $this->assertPageContainsText($notice);
    }

    /**
     * @dataProvider testContactDataProvider
     */
    public function testContact($address, $message, $notice, $count)
    {
        $this->crawlerIsSettedUp();
        $this->contactFormWasSubmitted($address, $message);
        $this->thenIseeNotice($notice);

        $this->mailCollector = $this->client->getProfile()->getCollector('swiftmailer');

        $this->thenMessageBeenSent($address, $count);
    }

    public function testContactDataProvider()
    {
        return array(
            array(
                "address" => "uirapuru@tlen.pl",
                "message" => "some message for testing",
                "notice"  => "Dziękujemy! Twoja wiadomość zostanie zaraz przeczytana",
                "count"   => 1
            ),
            array(
                "address" => "uirapuru",
                "message" => "some message for testing",
                "notice"  => "Nieprawidłowy adres email.",
                "count"   => 0
            ),
            array(
                "address" => "",
                "message" => "some message for testing",
                "notice"  => "Musisz podać email!",
                "count"   => 0
            ),
            array(
                "address" => "uirapuru@tlen.pl",
                "message" => "",
                "notice"  => "Musisz podać treść wiadomości!",
                "count"   => 0
            ),
            array(
                "address" => "uirapuru@tlen.pl",
                "message" => "123",
                "notice"  => "Wiadomość jest zbyt krótka, powinna zawierać conajmniej 10 znaków",
                "count"   => 0
            ),
            array(
                "address" => "uirapuru@tlen.pl",
                "message" => str_repeat("abcde", 300),
                "notice"  => "Wiadomość jest zbyt długa, powinna zawierać maksymalnie 1000 znaków",
                "count"   => 0
            ),
        );
    }

    public function testRegisterDataProvider()
    {
        return array(
            array(
                "username"  => 'uirapuru',
                'password1' => '123',
                'password2' => '123',
                'email'     => 'uirapuru123@tlen.pl',
                'notice'    => 'Inny użytkownik używa już tej nazwy'
            ),
            array(
                "username"  => 'uirapuru123',
                'password1' => '123',
                'password2' => '123',
                'email'     => 'uirapuru@tlen.pl',
                'notice'    => 'Inny użytkownik używa już tego adresu email'
            ),
            array(
                "username"  => 'uirapuru123',
                'password1' => '123',
                'password2' => '1234',
                'email'     => 'uirapuru123@tlen.pl',
                'notice'    => 'fos_user.password.mismatch'
            ),
        );
    }

    private function thenMessageBeenSent($address, $count)
    {
        $this->assertEquals($count, $this->mailCollector->getMessageCount());

        if ($count == 1) {
            $collectedMessages = $this->mailCollector->getMessages();
            $message = $collectedMessages[0];

            // Asserting e-mail data
            $this->assertInstanceOf('Swift_Message', $message);
            $this->assertEquals("Formularz kontaktowy - GyMan.pl", $message->getSubject());
            $this->assertEquals($address, key($message->getFrom()));
            $this->assertEquals("some@email.com", key($message->getTo()));
            $this->assertContains(
                'Wiadomość wysłana o godzinie',
                $message->getBody()
            );
        }
    }

    private function thenIseeNotice($notice)
    {
        $this->assertTrue($this->crawler->filter('html:contains("' . $notice . '")')->count() > 0);
    }

    private function contactFormWasSubmitted($address, $message)
    {
        $form = $this->crawler->selectButton('Wyślij')->form();

        $form['contact_form[email]'] = $address;
        $form['contact_form[message]'] = $message;

        $this->crawler = $this->client->submit($form);
    }

    private function loginFormWasSubmitted($username, $password)
    {
        $form = $this->crawler->filter('button:contains("account.login.label.submit")')->form();

        $form['_username'] = $username;
        $form['_password'] = $password;

        $this->crawler = $this->client->submit($form);
    }

    private function registerFormWasSubmitted($username, $password1, $password2, $email)
    {
        $form = $this->crawler->filter('button:contains("account.register.label.submit")')->form();

        $form['dende_registration_form[username]'] = $username;
        $form['dende_registration_form[plainPassword][first]'] = $password1;
        $form['dende_registration_form[plainPassword][second]'] = $password2;
        $form['dende_registration_form[email]'] = $email;

        $this->crawler = $this->client->submit($form);
    }
}
