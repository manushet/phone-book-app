<?php

namespace App\Kernel;

use App\Exceptions\ConfigFileNotFoundException;

class Services
{

    private array $services;

    private const CONFIG_PATH = CONFIG . '/services.php';

    public function isValidConfigFile(): bool
    {
        if (file_exists(self::CONFIG_PATH)) {
            return true;
        } else {
            throw new ConfigFileNotFoundException();
        }
    }

    public function registerServices(): void
    {
        if ($this->isValidConfigFile()) {
            $services = require_once(self::CONFIG_PATH);

            foreach ($services as $class => $params) {
                $this->services[$class] = $params;
            }
        }
    }

    public function load($class)
    {
        $params = isset($this->services[$class]) ? $this->services[$class] : [];

        $args = [];

        if (count($params) > 0) {
            foreach ($params as $param) {
                $args[] = $this->load($param);
            }
        }

        $class = str_ireplace("::class", "", $class);

        return new $class(...$args);
    }
}
