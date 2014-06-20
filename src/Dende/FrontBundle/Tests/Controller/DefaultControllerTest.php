<?php

namespace Dende\FrontBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{

    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
        
        $this->assertTrue($crawler->filter('html:contains("GyMan w skrócie")')->count() > 0);
    }

    /**
     * @dataProvider testContactDataProvider
     */
    public function testContact($address,$message,$notice, $count)
    {
        $this->crawlerIsSettedUp();
        $this->contactFormWasSubmitted($address,$message);        
        $this->thenIseeNotice($notice);
        
        $this->mailCollector = $this->client->getProfile()->getCollector('swiftmailer');
        
        $this->thenMessageBeenSent($address, $count);
    }

    public function testContactDataProvider() {
        return array(
            array(
                "address"   => "uirapuru@tlen.pl",
                "message"   => "some message for testing",
                "notice"    => "Dziękujemy! Twoja wiadomość zostanie zaraz przeczytana",
                "count"     => 1
            ),
            array(
                "address"   => "uirapuru",
                "message"   => "some message for testing",
                "notice"    => "Nieprawidłowy adres email.",
                "count"     => 0
            ),
            array(
                "address"   => "",
                "message"   => "some message for testing",
                "notice"    => "Musisz podać email!",
                "count"     => 0
            ),
            array(
                "address"   => "uirapuru@tlen.pl",
                "message"   => "",
                "notice"    => "Musisz podać treść wiadomości!",
                "count"     => 0
            ),
            array(
                "address"   => "uirapuru@tlen.pl",
                "message"   => "123",
                "notice"    => "Wiadomość jest zbyt krótka, powinna zawierać conajmniej 10 znaków",
                "count"     => 0
            ),
            array(
                "address"   => "uirapuru@tlen.pl",
                "message"   => str_repeat("abcde", 300),
                "notice"    => "Wiadomość jest zbyt długa, powinna zawierać maksymalnie 1000 znaków",
                "count"     => 0
            ),
        );
    }
    
    private function thenMessageBeenSent($address,$count) {
        $this->assertEquals($count, $this->mailCollector->getMessageCount());

        if($count == 1) {
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
    
    private function thenIseeNotice($notice) {
        $this->assertTrue($this->crawler->filter('html:contains("'.$notice.'")')->count() > 0);
    }
    
    private function contactFormWasSubmitted($address,$message)
    {
        $form = $this->crawler->selectButton('Wyślij')->form();

        $form['contact_form[email]'] = $address;
        $form['contact_form[message]'] = $message;

        $this->crawler = $this->client->submit($form);
    }
    
    private function crawlerIsSettedUp()
    {
        $this->client = static::createClient();
        $this->client->enableProfiler();
        $this->crawler = $this->client->request('GET', '/contact');
    }
    
}
