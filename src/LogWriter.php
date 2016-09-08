<?php
namespace Logger;

use ReflectionClass;
use Psr\Log\LogLevel;
use Psr\Log\InvalidArgumentException;

abstract class LogWriter
{
    protected $logStream;
    public $dateTpl = 'Y-m-d H:i:s';

    public function hardStringify($message)
    {
        if (is_object($message)) {
            $rc = new ReflectionClass(get_class($message));
            if (!$rc->hasMethod('__toString')) {
                $message = serialize($message);
            }
            unset($rc);
        }
        return $message;
    }

    public function useContext($message, array $context)
    {
        $replace = array();
        foreach ($context as $key => $val) {
            $replace['{' . $key . '}'] = $val;
        }
        return strtr($message, $replace);
    }
    public function log($level, $message, array $context)
    {
        $rc = new ReflectionClass('Psr\Log\LogLevel');
        try {
            if (!array_search($level, $rc->getConstants())) {
                throw new InvalidArgumentException("Система не поддерживает данный уровень протоколирования ($level)");
            }
        } catch (InvalidArgumentException $e) {
            echo $e->getMessage()."\n";
        }
        unset($rc);
        return $message = $this->useContext($this->hardStringify($message), $context);
    }
}
