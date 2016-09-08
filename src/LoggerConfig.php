<?php 
namespace Logger;

use Exception;

class LoggerConfig
{
    protected static $instance;
    public $config;
    protected function __construct()
    {
    }
    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }
    public function setMode($mode, array $param = array())
    {
        $logSpace = 'Logger\LogWriters\\'.$mode;
        $this->config = new $logSpace($param);
        if (!$this->config instanceof LogWriter) {
            unset($this->config);
            $this->config = null;
            throw new Exception('Класс '.$mode.' не является наследником LogWriter');
        }
    }
}
