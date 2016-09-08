<?php
namespace Logger\LogWriters;

use SplFileObject;
use RuntimeException;
use Logger\LogWriter;

class LogFile extends LogWriter
{
    public function __construct(array $config = array())
    {
        if (isset($config['path'])) {
            try {
                $this->logStream = new SplFileObject($config['path'], 'a');
            } catch (RuntimeException $e) {
                echo $e->getMessage()."\n";
            }
        }
    }
    public function log($level, $message, array $context = array())
    {
        if (!$this->logStream instanceof SplFileObject) {
            return false;
        }
        $message = parent::log($level, $message, $context);
        $datetime = date($this->dateTpl);
        $this->logStream->fwrite("[$datetime] [$level] => $message\n\n");
    }
    public function __destruct()
    {
        $this->logStream = null;
    }
}
