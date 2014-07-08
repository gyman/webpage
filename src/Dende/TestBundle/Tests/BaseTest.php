<?php

namespace Dende\TestBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Dende\TestBundle\Traits\SetupTrait;

class BaseTest extends WebTestCase
{

    use SetupTrait;
    
    /**
     *
     * @var Client
     */
    protected $client;
    
    /**
     *
     * @var Crawler
     */
    protected $crawler;
    
    protected function clientIsSettedUp()
    {
        $url = "http://" . $this->getContainer()->getParameter("testing_url");
        
        $this->client = static::createClient(array(
                    'HTTP_HOST'   => $url,
                    'SERVER_NAME' => $url
        ));
        $this->client->enableProfiler();
        $this->client->followRedirects();
    }
    
    protected function loginFormWasSubmitted($username, $password)
    {
        $form = $this->crawler->filter('button:contains("account.login.label.submit")')->form();

        $form['_username'] = $username;
        $form['_password'] = $password;

        $this->crawler = $this->client->submit($form);
    }
    
    protected function userIsLoggedIn($user, $pass)
    {
        $this->getPage("/login");
        $this->assertPageContainsText("account.login.header_link_login");
        $this->assertPageResponseCode(200);
        
        $this->loginFormWasSubmitted($user, $pass);
        
        $this->assertPageContainsText("account.title.caption");
        $this->assertPageResponseCode(200);
    }
    
    protected function assertPageContainsText($text = '')
    {
        $this->assertTrue($this->crawler->filter('html:contains("'.$text.'")')->count() > 0);
    }
    
    protected function assertPageResponseCode($code = 200)
    {
        $this->assertEquals($code, $this->client->getResponse()->getStatusCode());
    }
    
    protected function getPage($uri)
    {
        $this->crawler = $this->client->request('GET', $uri);
    }
    
    protected function postPage($uri)
    {
        $this->crawler = $this->client->request('POST', $uri);
    }
    
    protected function fixturesAreLoaded()
    {
        $loader = $this->getContainer()->get('data_fixture_loader');

        $root = dirname($this->getContainer()->get('kernel')->getRootDir());

        $loader->load([
            $root . "/src/Dende/TestBundle/DataFixtures/ORM"
        ]);
    }
}
