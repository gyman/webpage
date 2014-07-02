<?php

namespace Dende\SubscriptionBundle\Entity;

class SubscriptionFactory
{
    public function createSubscription($type, $parameters = array())
    {
        if ($type == null) {
            throw new \Exception("You must specify subscription type to get proper object");
        }
        
        $class = "Dende\\SubscriptionBundle\\Entity\\". ucfirst($type). "Subscription";
        
        $object = new $class;
        
        foreach ($parameters as $parameter => $value) {
            $method = "set" . ucfirst($parameter);
            if (!method_exists($object, $method)) {
                throw new \BadMethodCallException("Parameter $parameter for Subscription does not exists");
            }
            
            $object->$method($value);
        }
        
        return $object;
    }
}
