<?php

namespace Haleks\Tests\Markdown;

class MarkdownTest extends MarkdownTestCase
{
    /**
     * @test
     */
    public function it_can_compile_markdown_tags()
    {
        $actual = $this->app['view']->make('stubs::withtags')->render();
        $expected = "<h1>title</h1>\n<h2>subtitle</h2>\n<p>text</p>\n";

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function it_can_compile_markdown_tags_defaults()
    {
        $actual = $this->app['view']->make('stubs::withtagsdefaults')->render();
        $expected = "<h1>title</h1>\n<h2>subtitle</h2>\n<p>text</p>\n";

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function it_can_ignore_markdown_tags()
    {
        $actual = $this->app['view']->make('stubs::ignore')->render();
        $expected = "{% javascript %}\n<p>text</p>\n";

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function it_can_compile_markdown_files()
    {
        $actual = $this->app['view']->make('stubs::markdown')->render();
        $expected = "<h1>title</h1>\n<h2>subtitle</h2>\n<p>text</p>\n";

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function it_can_compile_markdown_blade_php_files()
    {
        $actual = $this->app['view']->make('stubs::markdownblade')->render();
        $expected = "<h1>title</h1>\n<h2>subtitle</h2>\n<p>text</p>\n";

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function it_can_compile_markdown_php_files()
    {
        $actual = $this->app['view']->make('stubs::markdownphp')->render();
        $expected = "<h1>title</h1>\n<h2>subtitle</h2>\n<p>text</p>\n";

        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function it_can_compile_markdown_extension()
    {
        $actual = $this->app['view']->make('stubs::extension')->render();
        $expected = "<h1 id=\"id\">title</h1>\n<h2 class=\"class\" id=\"id\">subtitle</h2>\n<p class=\"class\">text</p>\n";

        $this->assertSame($expected, $actual);
    }
}
