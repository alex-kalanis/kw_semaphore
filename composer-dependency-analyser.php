<?php

/**
 * Dependency analyzer configuration
 * @link https://github.com/shipmonk-rnd/composer-dependency-analyser
 */

use ShipMonk\ComposerDependencyAnalyser\Config\Configuration;
use ShipMonk\ComposerDependencyAnalyser\Config\ErrorType;

$config = new Configuration();

return $config
    // ignore errors on specific packages and paths
    ->ignoreErrorsOnPackageAndPath('alex-kalanis/kw_storage', __DIR__ . '/php-src/Semaphore/Storage.php', [ErrorType::DEV_DEPENDENCY_IN_PROD])
    ->ignoreErrorsOnPackageAndPath('alex-kalanis/kw_files', __DIR__ . '/php-src/Semaphore/Files.php', [ErrorType::DEV_DEPENDENCY_IN_PROD])
;
