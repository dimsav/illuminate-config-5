<?php

namespace MyApp;

use Dotenv;

class Application
{

    /**
     * @var Config
     */
    public $config;

    /**
     * @var array
     */
    protected $paths = [];

    public function __construct()
    {
        $this->setupPaths();
        $this->config = new Config();
        $this->config->loadConfigurationFiles($this->paths['config_path'], $this->getEnvironment());
    }

    private function setupPaths()
    {
        $this->paths['env_file_path'] = __DIR__ . '/../';
        $this->paths['env_file']      = $this->paths['env_file_path'].'.env';
        $this->paths['config_path'] = __DIR__ . '/../config';
    }

    private function getEnvironment()
    {
        if (is_file($this->paths['env_file'])) {
            Dotenv::load($this->paths['env_file_path']);
        }

        return getenv('ENVIRONMENT') ?: 'production';
    }
}