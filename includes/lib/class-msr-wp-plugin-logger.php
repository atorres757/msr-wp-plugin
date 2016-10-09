<?php

use Monolog\Logger;
use Monolog\Handler\ErrorLogHandler;

class MsrWpLogger
{
    
    private static $instance;
    private $logger;
    
    private function __construct()
    {
        $this->logger = new Logger('msr_wp_plugin');
        $this->logger->pushHandler(new ErrorLogHandler());
    }
    
    /**
     * Returns an instance of the logger.
     * 
     * @return MsrWpLogger
     */
    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new MsrWpLogger();
        }
        
        return self::$instance;
    }
    
    /**
     * Supported methods include all of which are currenlty supported by Monolog.
     * 
     * @param string $method Monolog method name.
     * @param array $args    Method args.
     */
    public function __call($method, $args)
    {
        return call_user_func_array(array($this->logger, $method), $args);
    }
}