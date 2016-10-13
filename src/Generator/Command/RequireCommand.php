<?php

namespace Tooly\Composer\Generator\Command;

use Composer\Command\BaseCommand;
use Composer\Factory;
use Composer\Json\JsonFile;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Tooly\Composer\Generator\Questions\ForceReplaceQuestion;
use Tooly\Composer\Generator\Questions\NameQuestion;
use Tooly\Composer\Generator\Questions\OnlyDevQuestion;
use Tooly\Composer\Generator\Questions\UrlQuestion;

class RequireCommand extends BaseCommand
{
    protected function configure()
    {
        $this
            ->setName('require-phar')
            ->setDescription('@todo');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = $this->getIO();
        $helper = new QuestionHelper;

        $nameQuestion = new NameQuestion;
        $urlQuestion = new UrlQuestion;

        $name = $helper->ask($input, $output, $nameQuestion);
        $url  = $helper->ask($input, $output, $urlQuestion);
        $forceReplace = $helper->ask($input, $output, new ForceReplaceQuestion);
        $onlyDev = $helper->ask($input, $output, new OnlyDevQuestion);

        $nameQuestion->saveAutocompleterValues($name);
        $urlQuestion->saveAutocompleterValues($url);

        $file = Factory::getComposerFile();
        $json = new JsonFile($file);

        $composerDefinition = $json->read();
        $composerDefinition['extra']['tools'][] = [
            $name => [
                'url' => $url,
                'only-dev' => $onlyDev,
                'force-replace' => $forceReplace,
            ]
        ];

        $json->write($composerDefinition);

        $output->write($name);

        return 0;
    }
}
