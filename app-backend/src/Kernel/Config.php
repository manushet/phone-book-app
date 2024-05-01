<?php

declare(strict_types=1);

namespace App\Kernel;

class Config
{
    private const PATH = ROOT . '/.env';

    public static function loadEnvironment(): void
    {
        $env = file_get_contents(self::PATH);

        if (static::validateEnvFile()) {
            $lines = explode("\n", $env);

            foreach ($lines as $line) {
                preg_match("/([^#]+)\=(.*)/", $line, $matches);

                if (isset($matches[2])) {
                    putenv(trim($line));
                }
            }
        }
    }

    private static function validateEnvFile(): bool
    {
        if (!file_exists(self::PATH)) {
            throw new \InvalidArgumentException(sprintf('%s does not exist', self::PATH));
        }

        if (!is_readable(self::PATH)) {
            throw new \RuntimeException(sprintf('%s file is not readable', self::PATH));
        }

        return true;
    }
}