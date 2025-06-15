<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__ . '/src')
    ->exclude('var');

$header = <<<EOF
Free to use, modify, distribute. No warranty. Include license.
EOF;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        '@Symfony:risky' => true,
        '@PHP82Migration' => true,
        'array_syntax' => ['syntax' => 'short'],
        'blank_line_before_statement' => true,
        'concat_space' => ['spacing' => 'one'],
        'header_comment' => [
            'header' => $header,
            'comment_type' => 'PHPDoc',
            'location' => 'after_open',
            'separate' => 'both',
        ],
    ])
    ->setFinder($finder);

