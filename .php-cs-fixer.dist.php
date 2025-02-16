<?php

$header = <<<'EOF'
this file is part of the json translatable POC.
(c) wicliff <wicliff.wolda@gmail.com>

for the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

$finder = (new PhpCsFixer\Finder())
    ->in([__DIR__ . '/src/', __DIR__ . '/tests/'])
    ->name('*.php')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'header_comment' => ['header' => $header],
    ])
    ->setRiskyAllowed(true)
    ->setFinder($finder)
;
