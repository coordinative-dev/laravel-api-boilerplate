<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude([
        'bootstrap',
        'gulpit',
        'public',
        'resources',
        'storage',
        'vendor',
        'nova',
    ])
    ->notName('_ide_helper.php')
    ->in(__DIR__);

$config = PhpCsFixer\Config::create()
    ->setRules([
        '@Symfony' => true,
        'phpdoc_order' => true,
        'phpdoc_align' => false,
        'phpdoc_summary' => false,
        'phpdoc_inline_tag' => false,
        'pre_increment' => false,
        'heredoc_to_nowdoc' => false,
        'cast_spaces' => false,
        'include' => false,
        'phpdoc_no_package' => false,
        'concat_space' => ['spacing' => 'one'],
        'ordered_imports' => true,
        'ordered_class_elements' => true,
        'phpdoc_add_missing_param_annotation' => true,
        'array_syntax' => ['syntax' => 'short'],
        'visibility_required' => true,
        'yoda_style' => false,
        'no_useless_return' => true,
        'phpdoc_no_empty_return' => false,
    ])
    ->setFinder($finder);

return $config;
