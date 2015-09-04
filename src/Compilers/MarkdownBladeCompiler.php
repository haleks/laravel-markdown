<?php

namespace Haleks\Markdown\Compilers;

use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Compilers\CompilerInterface;

class MarkdownBladeCompiler extends BladeCompiler implements CompilerInterface
{
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

        $contents = $this->compileString($this->files->get($this->getPath()));

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
}
