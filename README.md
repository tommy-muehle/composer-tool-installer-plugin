> Welcome! [Introduction for BETA testers](https://github.com/tommy-muehle/composer-tool-installer-plugin/wiki/Introduction-for-BETA-testers)

=======

# composer-tool-installer-plugin

[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.6-8892BF.svg?style=flat-square)](https://php.net/)

> Install project requirements with composer

This plugin is the right choice if your composer-project requires some extra binaries (own Go-Lang binaries) or an 
special toolset for testing (PHPUnit, PhantomJS, ...) or some tools for QA control (phpcs, phpmd, security-checker, ...).

With this plugin you can manage all this stuff in your project composer.json file. So you can be sure that all developers in your 
project get the required files in the needed version, optional with GPG signature or Pub-Key verification for each requirement.

Every required file will be saved in the [composer binary directory](https://getcomposer.org/doc/articles/vendor-binaries.md)

> This plugin is heavily inspired on [tooly-composer-script](https://github.com/tommy-muehle/tooly-composer-script) - PHAR management with composer

## Requirements

* PHP >= 5.6
* composer

## Install

```
composer require tm/composer-tool-installer-plugin
```

Or if you want to use it in multiple projects:

```
composer global require tm/composer-tool-installer-plugin
```

## Usage

The composer.json scheme has a part "extra" which is used in this plugin.
Its described [here](https://getcomposer.org/doc/04-schema.md#extra).

To add a requirement (tool or binary) you can add this manually (see section below) to the project composer.json file or you can use the composer CLI.
Every time you use the command the given values are saved, in the composer cache directory, and are proposed on the next time.

```
composer tool-installer:install
```

If you want to see the current configuration simply run: 

```
composer tool-installer:show
```

## Configuration

You can find a sample configuration [here](composer.json#L60-L78). The complete configuration options are described in the [wiki](https://github.com/tommy-muehle/composer-tool-installer-plugin/wiki/Configuration-parameters).

### Examples

* [PHPUnit] with GPG verification

```
{
    ...
    "extra": {
        "tools": {
            "phpunit": {
                "url": "https://phar.phpunit.de/phpunit-5.6.1.phar",
                "sign-url": "https://phar.phpunit.de/phpunit-5.6.1.phar.asc",
            }
        }
    }
    ...
}
```

* [humhub] with needed pub-key

```
{
    ...
    "extra": {
        "tools": {
            "humbug": {
                "url": "https://github.com/padraic/humbug/releases/download/1.0.0-alpha2/humbug.phar",
                "key-url": "https://github.com/padraic/humbug/releases/download/1.0.0-alpha2/humbug.phar.pubkey",
            }
        }
    }
    ...
}
```

* [own binary] not only for developing

```
{
    ...
    "extra": {
        "tools": {
            "my-binary": {
                "url": "https://my-package-server/my-binary.bin",
                "only-dev": false
            }
        }
    }
    ...
}
```

## Contribution

Please refer to [CONTRIBUTING.md](CONTRIBUTING.md) for information on how to contribute.
