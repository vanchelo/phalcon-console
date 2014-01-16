<?php namespace Vanchelo\Console;

class AccessCheck implements AccessInterface, \Phalcon\DI\InjectionAwareInterface
{
    protected $di;

    /**
     * Returns the internal dependency injector
     *
     * @return \Phalcon\DiInterface
     */
    public function getDI()
    {
        return $this->di;
    }

    /**
     * Sets the dependency injector
     *
     * @param \Phalcon\DiInterface $di
     */
    public function setDI($di)
    {
        $this->di = $di;
    }

    /**
     * Check access rights
     *
     * @return bool
     */
    public function check() {
        $config = $this->di['console.config'];

        if ( ! $config->check_ip)
        {
            return true;
        }

        $filter = $config->filter;
        $ips = $config->$filter->toArray();
        $ip = $this->di['request']->getClientAddress();

        if ($filter == $config->whitelist and in_array($ip, $ips))
        {
            return true;
        }
        elseif ($filter == $config->blacklist and ! in_array($ip, $ips))
        {
            return true;
        }

        return false;
    }

}