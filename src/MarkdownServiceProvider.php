<?php

namespace Haleks\Markdown;

use Haleks\Markdown\Compilers\BladeExtCompiler;
use Haleks\Markdown\Compilers\MarkdownCompiler;
use Haleks\Markdown\Compilers\MarkdownPhpCompiler;
use Haleks\Markdown\Compilers\MarkdownBladeCompiler;
use Haleks\Markdown\Engines\MarkdownEngine;
use League\CommonMark\DocParser;
use League\CommonMark\Environment;
use League\CommonMark\HtmlRenderer;
use League\CommonMark\Converter;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Engines\CompilerEngine;

class MarkdownServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/markdown.php' => config_path('markdown.php'),
        ], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/markdown.php', 'markdown');

        $this->registerMarkdownEnvironment();
        $this->registerMarkdownParser();
        $this->registerMarkdownHtmlRenderer();
        $this->registerMarkdown();
        $this->registerEngines();
    }

    /**
     * Register the CommonMark Environment.
     *
     * @return void
     */
    protected function registerMarkdownEnvironment()
    {
        $app = $this->app;

        $app->singleton('commonmark.environment', function ($app) {
            $config = $app['config']['markdown'];
            $environment = Environment::createCommonMarkEnvironment();

            if ($config['configurations']) {
                $environment->mergeConfig($config['configurations']);
            }

            foreach ($config['extensions'] as $extension) {
                if (class_exists($extension)) {
                    $environment->addExtension(new $extension());
                }
            }

            return $environment;
        });

        $app->alias('commonmark.environment', Environment::class);
    }

    /**
     * Register the CommonMark DocParser.
     *
     * @return void
     */
    protected function registerMarkdownParser()
    {
        $app = $this->app;

        $app->singleton('commonmark.docparser', function ($app) {
            $environment = $app['commonmark.environment'];

            return new DocParser($environment);
        });

        $app->alias('commonmark.docparser', DocParser::class);
    }

    /**
     * Register the CommonMark HTML Renderer.
     *
     * @return void
     */
    protected function registerMarkdownHtmlRenderer()
    {
        $app = $this->app;

        $app->singleton('commonmark.htmlrenderer', function ($app) {
            $environment = $app['commonmark.environment'];

            return new HtmlRenderer($environment);
        });

        $app->alias('commonmark.htmlrenderer', HtmlRenderer::class);
    }

    /**
     * Register the CommonMarkConverter.
     *
     * @return void
     */
    protected function registerMarkdown()
    {
        $app = $this->app;

        $app->singleton('markdown', function ($app) {
            return new Converter($app['commonmark.docparser'], $app['commonmark.htmlrenderer']);
        });

        $app->alias('markdown', Converter::class);
    }

    /**
     * Register the service provider engines.
     *
     * @return void
     */
    protected function registerEngines()
    {
        $app = $this->app;
        $config = $app['config'];
        $resolver = $app['view.engine.resolver'];

        if ($config['markdown.tags']) {
            $this->registerBladeEngine($resolver);
        }

        if ($config['markdown.views']) {
            $this->registerMarkdownEngine($resolver);
            $this->registerMarkdownPhpEngine($resolver);
            $this->registerMarkdownBladeEngine($resolver);
        }
    }

    /**
     * Overwrite the Blade engine implementation.
     *
     * @return void
     */
    protected function registerBladeEngine($resolver)
    {
        $app = $this->app;

        $app->singleton('blade.compiler', function ($app) {
            $cache = $app['config']['view.compiled'];

            return new BladeExtCompiler($app['files'], $cache);
        });

        $resolver->register('blade', function () use ($app) {
            return new CompilerEngine($app['blade.compiler'], $app['files']);
        });
    }

    /**
     * Register the Markdown engine implementation.
     *
     * @return void
     */
    protected function registerMarkdownEngine($resolver)
    {
        $app = $this->app;

        $app->singleton('markdown.compiler', function ($app) {
            $cache = $app['config']['view.compiled'];

            return new MarkdownCompiler($app['files'], $cache);
        });

        $resolver->register('markdown', function () use ($app) {
            return new MarkdownEngine($app['markdown.compiler'], $app['files']);
        });

        $app['view']->addExtension('md', 'markdown');
    }

    /**
     * Register the Markdown Php engine implementation.
     *
     * @return void
     */
    protected function registerMarkdownPhpEngine($resolver)
    {
        $app = $this->app;

        $app->singleton('markdown.php.compiler', function ($app) {
            $cache = $app['config']['view.compiled'];

            return new MarkdownPhpCompiler($app['files'], $cache);
        });

        $resolver->register('markdown.php', function () use ($app) {
            return new MarkdownEngine($app['markdown.php.compiler'], $app['files']);
        });

        $app['view']->addExtension('md.php', 'markdown.php');
    }

    /**
     * Register the Markdown Blade engine implementation.
     *
     * @return void
     */
    protected function registerMarkdownBladeEngine($resolver)
    {
        $app = $this->app;

        $app->singleton('markdown.blade.compiler', function ($app) {
            $cache = $app['config']['view.compiled'];

            return new MarkdownBladeCompiler($app['files'], $cache);
        });

        $resolver->register('markdown.blade', function () use ($app) {
            return new MarkdownEngine($app['markdown.blade.compiler'], $app['files']);
        });

        $app['view']->addExtension('md.blade.php', 'markdown.blade');
    }
}
