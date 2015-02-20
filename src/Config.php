<?php

namespace MyApp;

use Illuminate\Config\Repository;
use Symfony\Component\Finder\Finder;

class Config extends Repository {

    /**
     * The directory containing the config files
     *
     * @var string
     */
    protected $configPath;

    /**
     * Load the configuration items from all of the files.
     *
     * @param      $path
     * @param null $environment
     */
    public function loadConfigurationFiles($path, $environment = null)
    {
        $this->configPath = $path;

        foreach ($this->getConfigurationFiles() as $fileKey => $path) {
            $this->set($fileKey, require $path);
        }

        foreach ($this->getConfigurationFiles($environment) as $fileKey => $path) {

            $envConfig = require $path;

            foreach ($envConfig as $envKey => $value) {
                $this->set($fileKey . '.' . $envKey, $value);
            }
        }
    }

    /**
     * Get the configuration files for the selected environment
     *
     * @param null $environment
     *
     * @return array
     */
    protected function getConfigurationFiles($environment = null)
    {
        $path = $environment ? $this->configPath . '/' . $environment : $this->configPath;

        if (!is_dir($path)) {
            return [];
        }

        $files = [];
        foreach (Finder::create()->files()->name('*.php')->in($path)->depth(0) as $file) {
            $files[basename($file->getRealPath(), '.php')] = $file->getRealPath();
        }
        return $files;
    }

}
