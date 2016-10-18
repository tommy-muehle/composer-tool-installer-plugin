=======
# composer-tool-installer-plugin

## Introduction for Beta testers

### Please add this parts to one or several projects composer.json file(s).

```
...
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/tommy-muehle/composer-tool-installer-plugin"
    }
],
...
"require-dev": {
    ...
    "tm/composer-tool-installer-plugin": "dev-master"
    ...
}
```

### Play with the plugin

To add a new tool simple run:

```
composer tool-installer:install
```

To show current tool configuration you can run:

```
composer tool-installer:show
```

## Example configurations

Instead of use the composer CLI you can also add the configuration directly to composer.json file. 

```
...
"extra": {
        "tools": {
            "phpunit": {
                "url": "https://phar.phpunit.de/phpunit-5.6.1.phar",
                "only-dev": true,
                "force-replace": false
            },
            "phantomjs": {
                "url": "path/to/phantomjs.bin",
                "only-dev": true,
                "force-replace": true
            }
        }
    }
...
```
