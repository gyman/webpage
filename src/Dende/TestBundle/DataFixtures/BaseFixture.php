<?php
namespace Dende\TestBundle\DataFixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;

class BaseFixture extends AbstractFixture implements OrderedFixtureInterface
{
    protected $manager;
    protected $fixtureFile;
    
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        
        $value = Yaml::parse(file_get_contents(__DIR__.$this->fixtureFile));
        
        foreach ($value as $key => $params) {
            $object = $this->insert($params);
            $this->addReference($key, $object);
        }
    }

    public function getOrder()
    {
        return 1;
    }

    private function insert($params)
    {
        throw new \Exception("Must implement this method!");
    }
}
