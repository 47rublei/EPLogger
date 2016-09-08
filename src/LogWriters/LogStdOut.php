<?php
namespace Logger\LogWriters;

use Logger\LogWriter;

class LogStdOut extends LogWriter
{
    public function log($level, $message, array $context = array())
    {
        $message = parent::log($message, $context);
        $datetime = date($this->dateTpl);
        fwrite(STDOUT, "[$datetime] [$level] => $message\n");
    }
}
