<?php

namespace Haleks\Markdown\Engines;

use Exception;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\EngineInterface;
use Illuminate\View\Compilers\CompilerInterface;

class MarkdownEngine extends CompilerEngine implements EngineInterface
{
    /**
     * Create a new Markdown view engine instance.
     *
     * @param  \Illuminate\View\Compilers\CompilerInterface  $compiler
     * @return void
     */
    public function __construct(CompilerInterface $compiler)
    {
        $this->compiler = $compiler;
    }

    /**
     * Get the evaluated contents of the view.
     *
     * @param  string  $path
     * @param  array   $data
     * @return string
     */
    public function get($path, array $data = [])
    {
        $this->lastCompiled[] = $path;

        // If this given view has expired, which means it has simply been edited since
        // it was last compiled, we will re-compile the views so we can evaluate a
        // fresh copy of the view. We'll pass the compiler the path of the view.
        if ($this->compiler->isExpired($path)) {
            $this->compiler->compile($path);
        }

        $compiled = $this->compiler->getCompiledPath($path);

        // Once we have the path to the compiled file, we will evaluate the paths with
        // typical PHP just like any other templates. We also keep a stack of views
        // which have been rendered for right exception messages to be generated.
        $results = $this->evaluatePath($compiled, $data);

        $results = $this->compiler->markdown($results);

        array_pop($this->lastCompiled);

        return $results;
    }
}
