<?php
include 'vendor/autoload.php';

Logger\LoggerConfig::getInstance()->setMode('LogStdOut');

// Logger\LoggerConfig::getInstance()->setMode('LogDB', [ 'host' => '192.168.5.112', 
//                                                 'user' => 'root',
//                                                 'password' => '',
//                                                 'database' => 'exampledb']);

// Logger\LoggerConfig::getInstance()->setMode('LogFile', ['path' => 'journal.log']);

$logger = new Logger\Logger();

$logger->debug($logger);
$logger->info('info message');
$logger->notice('notice message');
$logger->warning('warning message');
$logger->error('error message');
$logger->critical('critical message');
$logger->alert('alert message');
$logger->emergency('emergency message');
