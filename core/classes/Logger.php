<?php
namespace Makler;
class Logger
{
    private string $logFile; // Путь к файлу лога
    private string $dateFormat; // Формат даты
    private array $logLevels; // Уровни логов
    private int $maxFileSize; // Максимальный размер файла лога (в байтах)
    private int $maxFiles; // Максимальное количество архивных файлов
    private static ?Logger $instance = null;

    /**
     * Конструктор класса Logger (приватный для Singleton).
     */
    private function __construct(string $logFile, string $dateFormat = 'Y-m-d H:i:s', int $maxFileSize = 1048576, int $maxFiles = 5)
    {
        $this->logFile = $logFile;
        $this->dateFormat = $dateFormat;
        $this->logLevels = ['DEBUG', 'INFO', 'WARNING', 'ERROR', 'CRITICAL'];
        $this->maxFileSize = $maxFileSize;
        $this->maxFiles = $maxFiles;

        if (!file_exists($logFile)) {
            touch($logFile);
        }
    }

    /**
     * Получить Singleton-экземпляр Logger.
     */
    public static function getInstance(string $logFile, string $dateFormat = 'Y-m-d H:i:s', int $maxFileSize = 1048576, int $maxFiles = 5): Logger
    {
        if (self::$instance === null) {
            self::$instance = new self($logFile, $dateFormat, $maxFileSize, $maxFiles);
        }
        return self::$instance;
    }

    /**
     * Записать сообщение в лог.
     */
    public function log(string $level, string $message, array $context = []): void
    {
        if (!in_array($level, $this->logLevels)) {
            throw new \InvalidArgumentException("Invalid log level: $level");
        }

        $timestamp = date($this->dateFormat);
        $contextString = $this->formatContext($context);
        $formattedMessage = "[$timestamp] [$level] $message $contextString" . PHP_EOL;

        $this->writeToFile($formattedMessage);
        $this->rotateLogs();
    }

    /**
     * Уровень DEBUG.
     */
    public function debug(string $message, array $context = []): void
    {
        $this->log('DEBUG', $message, $context);
    }

    /**
     * Уровень INFO.
     */
    public function info(string $message, array $context = []): void
    {
        $this->log('INFO', $message, $context);
    }

    /**
     * Уровень WARNING.
     */
    public function warning(string $message, array $context = []): void
    {
        $this->log('WARNING', $message, $context);
    }

    /**
     * Уровень ERROR.
     */
    public function error(string $message, array $context = []): void
    {
        $this->log('ERROR', $message, $context);
    }

    /**
     * Уровень CRITICAL.
     */
    public function critical(string $message, array $context = []): void
    {
        $this->log('CRITICAL', $message, $context);
    }

    /**
     * Форматирование контекста.
     */
    private function formatContext(array $context): string
    {
        return !empty($context) ? json_encode($context) : '';
    }

    /**
     * Запись сообщения в файл.
     */
    private function writeToFile(string $message): void
    {
        file_put_contents($this->logFile, $message, FILE_APPEND | LOCK_EX);
    }

    /**
     * Ротация логов.
     */
    private function rotateLogs(): void
    {
        if (filesize($this->logFile) < $this->maxFileSize) {
            return;
        }

        for ($i = $this->maxFiles - 1; $i > 0; $i--) {
            $oldFile = $this->logFile . ".$i";
            $newFile = $this->logFile . '.' . ($i + 1);

            if (file_exists($oldFile)) {
                rename($oldFile, $newFile);
            }
        }

        rename($this->logFile, $this->logFile . '.1');
        touch($this->logFile);
    }

    /**
     * Запрет клонирования.
     */
    private function __clone()
    {
    }

    /**
     * Запрет десериализации.
     */
    public function __wakeup()
    {
        throw new RuntimeException("Cannot deserialize Logger instance.");
    }
}
