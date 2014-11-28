<?php namespace Vanchelo\Console;

use Phalcon\Mvc\User\Component;

class Console extends Component
{
    /**
     * Array with error code => string pairs.
     *
     * Used to convert error codes into human readable strings.
     *
     * @var array
     */
    public $error_map = [
        E_ERROR             => 'E_ERROR',
        E_WARNING           => 'E_WARNING',
        E_PARSE             => 'E_PARSE',
        E_NOTICE            => 'E_NOTICE',
        E_CORE_ERROR        => 'E_CORE_ERROR',
        E_CORE_WARNING      => 'E_CORE_WARNING',
        E_COMPILE_ERROR     => 'E_COMPILE_ERROR',
        E_COMPILE_WARNING   => 'E_COMPILE_WARNING',
        E_USER_ERROR        => 'E_USER_ERROR',
        E_USER_WARNING      => 'E_USER_WARNING',
        E_USER_NOTICE       => 'E_USER_NOTICE',
        E_STRICT            => 'E_STRICT',
        E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',
        E_DEPRECATED        => 'E_DEPRECATED',
        E_USER_DEPRECATED   => 'E_USER_DEPRECATED',
        E_ALL               => 'E_ALL',
    ];

    /**
     * Execution profile.
     *
     * @var array
     */
    public $profile = [
        'memory'      => 0,
        'memory_peak' => 0,
        'time'        => 0,
        'time_total'  => 0,
        'output'      => '',
        'output_size' => 0,
        'error'       => false
    ];

    /**
     * Adds one or multiple fields into profile.
     *
     * @param string $property Property name, or an array of name => value pairs.
     * @param mixed $value Property value.
     */
    public function addProfile($property, $value = null)
    {
        if (gettype($property) === 'array')
        {
            foreach ($property as $key => $value)
            {
                $this->addProfile($key, $value);
            }

            return;
        }

        // Normalize properties
        $normalizer_name = 'normalize' . ucfirst($property);
        if (method_exists(__CLASS__, $normalizer_name))
        {
            $value = call_user_func([__CLASS__, $normalizer_name], $value);
        }

        $this->profile[$property] = $value;
    }

    /**
     * Returns current profile.
     *
     * @return array
     */
    public function getProfile()
    {
        // Extend the profile with current data
        $this->addProfile([
            'memory'      => memory_get_usage(true),
            'memory_peak' => memory_get_peak_usage(true),
            'time_total'  => round((microtime(true) - PHALCONSTART) * 1000),
        ]);

        return $this->profile;
    }

    /**
     * Executes a code and returns current profile.
     *
     * @param  string $code
     *
     * @return array
     */
    public function execute($code)
    {
        // Execute the code
        ob_start();
        $console_execute_start = microtime(true);
        $estatus = @eval($code);
        $console_execute_end = microtime(true);
        $output = ob_get_contents();
        ob_end_clean();

        // Retrieve an error
        if ($estatus === false)
        {
            $this->addProfile('error', error_get_last());
        }

        // Extend the profile
        $this->addProfile([
            'time'        => round(($console_execute_end - $console_execute_start) * 1000, 2),
            'output'      => $output,
            'output_size' => strlen($output)
        ]);

        return $this->getProfile();
    }

    /**
     * Normalizes error profile.
     *
     * @param  mixed $error Error object or array.
     *
     * @return array Normalized error array.
     */
    public function normalizeError($error, $type = 0)
    {
        // Set human readable error type
        if (isset($error['type']) and isset($this->error_map[$error['type']]))
        {
            $error['type'] = $this->error_map[$error['type']];
        }

        // Validate and return the error
        if (isset($error['type'], $error['message'], $error['file'], $error['line']))
        {
            return $error;
        }
        else
        {
            return $this->profile['error'];
        }
    }

    /**
     * Render console
     *
     * @return string
     */
    public function render()
    {
        return $this->di['console.view']->render('console');
    }
}
