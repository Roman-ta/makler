<?php

namespace Makler;
class Logger
{
    private string $logFile;

    private function __construct(string $logFile)
    {
        $this->logFile = $logFile;
    }

    public static function log(string $logFile, array $context = []): void
    {
        $timeStamp = date("Y-m-d");
        $logFile .= '-'. $timeStamp .'.log';
        if(!file_exists($logFile)){
            touch($logFile);
        }
        if(!is_writable($logFile)) throw new \Exception('Log file is not writable');
        file_put_contents($logFile, $timeStamp . PHP_EOL, FILE_APPEND | LOCK_EX);
    }
}