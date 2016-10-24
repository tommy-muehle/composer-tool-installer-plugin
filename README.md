> Welcome! [Introduction for BETA testers](https://github.com/tommy-muehle/composer-tool-installer-plugin/wiki/Introduction-for-BETA-testers)

=======

# composer-tool-installer-plugin

> Install project requirements with composer

This plugin is the right choice if your composer-project requires some extra binaries (own Go-Lang binaries) or an 
special toolset for testing (such as PHPUnit, PhantomJS) or some tools for QA control (such as phpmd, security-checker, ...).

With this plugin you can manage all these things in your composer.json file. Team-transcending and optional with GPG signature or 
Pub-Key verification for each tool.

> This plugin is heavily inspired on [tooly-composer-script](https://github.com/tommy-muehle/tooly-composer-script) - PHAR management with composer

## Requirements

* PHP >= 5.6
* composer

## Install

```
composer require tm/composer-tool-installer-plugin ^1.0
```

## Usage

To add a requirement (tool or binary) you can add this manually to the composer.json file or you can use the composer CLI.
Every time you use the command the given values are saved, in the composer cache directory, and are proposed on the next time.

```
composer tool-installer:install
```

If you want to see the current configuration simply run: 

```
composer tool-installer:show
```

## Configuration

You can find a sample configuration [here](). The complete configuration options are described in the [wiki]().

### Examples

* [PHPUnit]() with GPG verification
* [humhub] with Key-Verification

## Contribution

Please refer to [CONTRIBUTING.md](CONTRIBUTING.md) for information on how to contribute.
