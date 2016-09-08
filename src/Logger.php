<?php
namespace Logger;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

class Logger extends AbstractLogger implements LoggerInterface
{
    public function log($level, $message, array $context = array())
    {
        LoggerConfig::getInstance()->config->log($level, $message, $context);
    }
}
