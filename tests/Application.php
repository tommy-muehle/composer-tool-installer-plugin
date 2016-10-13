<?php

namespace Tooly\Composer\Tests;

use Composer\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Command\ListCommand;
use Tooly\Composer\Generator\Command\RequireCommand;

class Application extends ConsoleApplication
{
    protected function getDefaultCommands()
    {
        return [
            new ListCommand,
            new RequireCommand
        ];
    }

}
