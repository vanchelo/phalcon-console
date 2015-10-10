<?php

namespace Vanchelo\Console;

use Phalcon\DI\InjectionAwareInterface;
use Phalcon\DiInterface;

class AccessCheck implements AccessInterface, InjectionAwareInterface
{
    /**
     * @var DiInterface
     */
    protected $di;

    /**
     * Returns the internal dependency injector
     *
     * @return DiInterface
     */
    public function getDI()
    {
        return $this->di;
    }

    /**
     * Sets the dependency injector
     *
     * @param DiInterface $di
     */
    public function setDI(DiInterface $di)
    {
        $this->di = $di;
    }

    /**
     * Check access rights
     *
     * @return bool
     */
    public function check()
    {
        $config = $this->di['console.config'];

        if (!$config->check_ip) {
            return true;
        }

        $filter = $config->filter;
        $ips = $config->$filter->toArray();
        $ip = $this->di['request']->getClientAddress();

        if (($filter == $config->whitelist) && in_array($ip, $ips)) {
            return true;
        } elseif (($filter == $config->blacklist) && !in_array($ip, $ips)) {
            return true;
        }

        return false;
    }
}
