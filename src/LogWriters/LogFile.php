<?php
namespace Logger\LogWriters;

use Logger\LogWriter;

class LogFile extends LogWriter
{
    public function __construct(array $config = array())
    {
        if (isset($config['path'])) {
            $this->logStream = fopen($config['path'], 'a');
        }
    }
    public function log($level, $message, array $context = array())
    {
        $message = parent::log($level, $message, $context);
        $datetime = date($this->dateTpl);
        fwrite($this->logStream, "[$datetime] [$level] => $message\n\n");
    }
    public function __destruct()
    {
        fclose($this->logStream);
    }
}
