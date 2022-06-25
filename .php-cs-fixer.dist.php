<?php

declare(strict_types=1);

// cuc z : https://github.com/pburggraf/CRC
// - ma tam funkcni verze

$finder = PhpCsFixer\Finder::create()
    ->exclude('php-tests/data')
    ->exclude('php-tests/external')
    ->in(__DIR__);

$config = new PhpCsFixer\Config();
$config
    ->setRiskyAllowed(true)
    ->setRules([
        '@Symfony' => false,
        'concat_space' => false,
        'phpdoc_order' => true,
        'cast_spaces' => true,
        'declare_strict_types' => false,
        'yoda_style' => [
            'equal' => true,
            'identical' => true,
            'less_and_greater' => true,
        ],
    ])
    ->setFinder($finder);

return $config;