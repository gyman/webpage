<?php

namespace Dende\TestBundle\Services;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;

class FixtureLoader
{

    private $entityManager;
    private $dataFixturesLoader;

    public function __construct(EntityManager $entityManager, Loader $dataFixturesLoader)
    {
        $this->entityManager = $entityManager;
        $this->dataFixturesLoader = $dataFixturesLoader;
    }

    public function load($dirOrFile, $append = false, $purgeMode = ORMPurger::PURGE_MODE_DELETE)
    {
        if ($dirOrFile) {
            $paths = is_array($dirOrFile) ? $dirOrFile : array($dirOrFile);
        } else {
            $paths = array();
        }

        foreach ($paths as $path) {
            if (is_dir($path)) {
                $this->dataFixturesLoader->loadFromDirectory($path);
            }
        }

        $fixtures = $this->dataFixturesLoader->getFixtures();

        if (!$fixtures) {
            throw new \InvalidArgumentException(
                sprintf('Could not find any fixtures to load in: %s', "\n\n- " . implode("\n- ", $paths))
            );
        }

        $purger = new ORMPurger($this->entityManager);
        $purger->setPurgeMode($purgeMode);
        $executor = new ORMExecutor($this->entityManager, $purger);

        $executor->execute($fixtures, $append);
    }
}
