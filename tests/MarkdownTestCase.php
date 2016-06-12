<?php

namespace Haleks\Tests\Markdown;

use Orchestra\Testbench\TestCase;

abstract class MarkdownTestCase extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('markdown.configurations', [
            'enable_em' => false,
        ]);

        $app['config']->set('markdown.extensions', [
            \Webuni\CommonMark\AttributesExtension\AttributesExtension::class,
        ]);

        $app['view']->addNamespace('stubs', realpath(__DIR__.'/stubs'));
    }

    protected function getPackageProviders($app)
    {
        return [
            \Haleks\Markdown\MarkdownServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Markdown' => \Haleks\Markdown\Facades\Markdown::class,
        ];
    }
}
