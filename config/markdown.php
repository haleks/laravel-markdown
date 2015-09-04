<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Enable Markdown Tags
    |--------------------------------------------------------------------------
    |
    | This option specifies if you want to extend the blade template with
    | markdown specific "curly" braces '{%' and '%}'.  This is a short-cut
    | to having to call the facade inside blade "curly" braces.
    |
    | Default: true
    |
    */

    'tags' => true,

    /*
    |--------------------------------------------------------------------------
    | Enable Views Extensions
    |--------------------------------------------------------------------------
    |
    | This option specifies if the view integration is enabled so you can write
    | markdown views and have them rendered as html. The following view
    | extensions will be supported: ".md", ".md.php", and ".md.blade.php".
    |
    | Default: true
    |
    */

    'views' => true,

    /*
    |--------------------------------------------------------------------------
    | Enable Markdown Extensions
    |--------------------------------------------------------------------------
    |
    | This option specifies the extensions to add to the CommonMark converter.
    | After extension is loaded you will be able to use those extension in the
    | markdown views or blade markdown tags
    |
    | Default: none
    |
    */

    'extensions' => [
        //
    ],

];
