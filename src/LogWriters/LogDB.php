<?php
namespace Logger\LogWriters;

use mysqli;
use Exception;
use Psr\Log\LogLevel;
use Logger\LogWriter;

class LogDB extends LogWriter
{
    private $logLevels = array(
                LogLevel::DEBUG => 1,
                LogLevel::INFO => 2,
                LogLevel::NOTICE => 3,
                LogLevel::WARNING => 4,
                LogLevel::ERROR => 5,
                LogLevel::CRITICAL => 6,
                LogLevel::ALERT => 7,
                LogLevel::EMERGENCY => 8
            );
    public function __construct(array $config = array())
    {
        try {
            if (isset($config['host']) &&
                isset($config['user']) &&
                isset($config['password']) &&
                isset($config['database'])) {
                $this->logStream = new mysqli(
                    $config['host'],
                    $config['user'],
                    $config['password'],
                    $config['database']
                );
            } else {
                throw new Exception("В конфигурации соединения к БД указаны не все требуемые параметры");
            }
        } catch (Exception $e) {
            echo $e->errorMessage()."\n";
        }
    }
    public function log($level, $message, array $context = array())
    {
        if ($this->logStream->connect_errno || !$this->logStream instanceof mysqli) {
            return false;
        }
        $message = parent::log($level, $message, $context);
        $query = "INSERT INTO epl_messages(datetime, message, level) VALUES(?, ?, ?)";
        $stmt = $this->logStream->prepare($query);
        $stmt->bind_param("sss", $dt, $msg, $lvl);
        $dt = date($this->dateTpl);
        $msg = $message;
        $lvl = $this->logLevels[$level];
        $stmt->execute();
        $stmt->close();
    }
    public function __destruct()
    {
        if ($this->logStream instanceof mysqli && !$this->logStream->connect_errno) {
            $this->logStream->close();
        }
    }
}
