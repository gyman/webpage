<?php

namespace Dende\TestBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Dende\TestBundle\Traits\SetupTrait;

class BaseTest extends WebTestCase {

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
    
    
    protected function crawlerIsSettedUp()
    {
        $url = $this->getContainer()->getParameter("testing_url");
        
        $this->client = static::createClient(array(
                    'HTTP_HOST'   => $url,
                    'SERVER_NAME' => $url
        ));
        $this->client->enableProfiler();
        $this->crawler = $this->client->request('GET', '/contact');
    }
    
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
    
    protected function assertPageContainsText($text = '')
    {
        $this->assertTrue($this->crawler->filter('html:contains("'.$text.'")')->count() > 0);
    }
    
    protected function assertPageResponseCode($code = 200)
    {
        $this->assertEquals($code,$this->client->getResponse()->getStatusCode());
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
