<?php

namespace Haleks\Markdown\Compilers;

use Illuminate\View\Compilers\Compiler;
use Illuminate\View\Compilers\CompilerInterface;

class MarkdownCompiler extends Compiler implements CompilerInterface
{
    /**
     * The file currently being compiled.
     *
     * @var string
     */
    protected $path;

    /**
     * Compile the view at the given path.
     *
     * @param  string  $path
     * @return void
     */
    public function compile($path = null)
    {
        if ($path) {
            $this->setPath($path);
        }

        $contents = app('markdown')->convertToHtml($this->files->get($this->getPath()));

        if (! is_null($this->cachePath)) {
            $this->files->put($this->getCompiledPath($this->getPath()), $contents);
        }
    }

    /**
     * Compile the view's markdown with given contents.
     *
     * @param  string  $contents
     * @return void
     */
    public function markdown($contents)
    {
        $contents = app('markdown')->convertToHtml($contents);

        if (! is_null($this->cachePath)) {
            $this->files->put($this->getCompiledPath($this->getPath()), $contents);
        }

        return $contents;
    }

    /**
     * Get the path currently being compiled.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set the path currently being compiled.
     *
     * @param  string  $path
     * @return void
     */
    public function setPath($path)
    {
        $this->path = $path;
    }
}
