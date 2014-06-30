<?php

namespace Dende\TestBundle\Traits;

trait SetupTrait {

    protected $container;

    public function setUp() {
        if (null !== static::$kernel)
        {
            static::$kernel->shutdown();
        }

        static::$kernel = static::createKernel(['environment' => 'test']);
        static::$kernel->boot();

        $this->container = static::$kernel->getContainer();
    }

    public function getContainer() {
        return $this->container;
    }

}
