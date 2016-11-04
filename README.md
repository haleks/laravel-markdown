<p align="center">
<a href="https://haleks.ca" target="_blank"><img src="https://haleks.ca/images/logo/haleks[markdown-orange].png" alt="haleks logo"></a>
</p>

<h1 align="center">
Laravel Markdown
<br>
<a href="https://travis-ci.org/haleks/laravel-markdown" target="_blank"><img src="https://img.shields.io/travis/haleks/laravel-markdown/master.svg?style=flat-square" alt="travic ci"></a>
<a href="https://github.com/haleks/laravel-markdown/releases" target="_blank"><img src="https://img.shields.io/github/release/haleks/laravel-markdown.svg?style=flat-square" alt="latest release"></a>
<a href="https://codeclimate.com/github/haleks/laravel-markdown" target="_blank"><img src="https://img.shields.io/codeclimate/github/haleks/laravel-markdown.svg?style=flat-square" alt="code climate"></a>
<a href="LISCENCE" target="_blank"><img src="https://img.shields.io/badge/license-MIT-ff4c00.svg?style=flat-square" alt="liscense"></a>
</h1>

Laravel Markdown integrate markdown "curly" braces inside the blade template engine, also giving the possibility of extending CommonMark.

## Documentation

### Pre-Installation
This project requires that the following packages be formerly installed.

[PHP](https://php.net) 5.5+ / [HHVM](http://hhvm.com) 3.6+

[Composer](https://github.com/composer/composer)  
```bash
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
```


### Installation

#### Pulling the package
Install via composer's require command:
```bash
composer require haleks/laravel-markdown
```

Install via your projects' `composer.json`:
```json
{
    ...
    "require": {
        "php": ">=5.5.9",
        "laravel/framework": "5.1.*",
        "haleks/laravel-markdown": "0.3.*"
    },
    ...
}
```

Once the package is in the require section you will need to run composer's `install` or `update` command to pull in the code:
```bash
# Install
composer install -o

# or Update
composer update -o
```
<sup>**Note**: The trailing `-o` is an optional option which is used to optimize the autoloader and is considered best practice.</sup>


#### Registering the package
Once the package as been successfully pulled you will need to register the package's service provider to the Laravel's app and optionally add the package's facade by modifying `config/app.php`:

```php
...
    'providers' => [
        ...
        Haleks\Markdown\MarkdownServiceProvider::class,

    ],
...

    'aliases' => [
        ...
        // Optional facade
        'Markdown' => Haleks\Markdown\Facades\Markdown::class,

    ],
...
```


#### Configuration
Laravel Markdown supports optional configuration.

You will need to pull the configuration in you app's configuration folder to make modifications to the default configuration.  You can achieve this with the following artisan command:

``` bash
php artisan vendor:publish
```

The configuration file will be created at `config/markdown.php`.


##### Options

###### Enable Markdown Tags
The option `tags` specifies if you wish to extend blade with markdown tags.  If set to `true` you will be able to render markdown via the "curly" braces  `{%` `%}` inside your `blade.php` files.

###### Enable Views Extensions
The option `views` specifies if you wish to intergrate extend views extensions.  If set to `true` you will be able to render markdown views with the following extensions:  `*.md`, `*.md.php`, and `*.md.blade.php`.

###### Enable Views Extensions
The option `extensions` specifies which extension you wish to intergrate inside the CommonMark converter.  It uses CommonMark environment's `addExtension()` method to load the extensions.


### How To Use

#### Facades
You may use the facade to pass markdown and return the equivalent html.  The Markdown facade has simply one method `convertToHtml('markdown here')`.

##### Inside classes
```php
$html = Markdown::convertToHtml('# title');
```

##### Blade Views
You will need to use the unescaped echo because the converter returns html.

```php
{!! Markdown::convertToHtml('# title') !!}
```

#### Tags Extensions
If the `tags` configuration is set to `true`.  You may use the following "curly" brace short-cut in your `*.blade.php` files.

```php
{% '# title' %}
```

Like Blade's escaped echo `{{` `}}` the markdown tags are also equipped with the short-cut ternary statement.  If the pass variable that doesn't exists the markdown will only parse the default.

```php
{% $variable or 'default' %}
```

If you are using a JavaScript template engine which uses the markdown "curly" braces, just like Blade's "curly" braces, you may add a leading `@` to leave it untouched for the JavaScript template engine.

```php
@{% javascript stuff %}
```

#### Views Extensions
If the `views` configuration is set to `true`.  You may use views with the following extensions: `*.md`, `*.md.php`, and `*.md.blade.php`.  The `*.md` views will parse the markdown and return the html equivalent, while the `*.md.php`, and `*.md.blade.php` will parse the php first and followed by the markdown.

```php
// *.md
# title

text
```
```php
// *.md.php
# <?php echo 'title' ?>

text
```
```php
// *.md.php
<?php echo '# title' ?>

text
```
```php
// *.md.blade.php
# {{ 'title' }}

text
```
```php
// *.md.blade.php
{{ '# title' }}

text
```

All the exemple above will output:

```html
<h1>title</h1>
<p>text</p>
```

#### Markdown Extensions
You may extend the Markdown compiler with any extension that uses CommonMark environment `addExtension()` method.

Here are a few extension known to be compatible:
- [Attributes Extension](https://github.com/webuni/commonmark-table-extension)
- [Tables Extension](https://github.com/webuni/commonmark-table-extension)


## License
Laravel Markdown is licensed under [The MIT License (MIT)](LICENSE).
