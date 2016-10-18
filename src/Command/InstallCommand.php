<?php

namespace ToolInstaller\Composer\Command;

use Composer\Command\BaseCommand;
use Composer\Factory;
use Composer\Json\JsonFile;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use ToolInstaller\Composer\Command\Questions\ForceReplaceQuestion;
use ToolInstaller\Composer\Command\Questions\NameQuestion;
use ToolInstaller\Composer\Command\Questions\OnlyDevQuestion;
use ToolInstaller\Composer\Command\Questions\SignUrlQuestion;
use ToolInstaller\Composer\Command\Questions\UrlQuestion;

class InstallCommand extends BaseCommand
{
    protected function configure()
    {
        $this
            ->setName('tool-installer:install')
            ->setDescription('@todo')
            ->setHelp(<<<EOT
@todo The <info>tool-installer:install</info> command needs a description.</info>
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $tool = $this->askQuestions($input, $output);

        $io = $this->getIO();
        $json = new JsonFile((Factory::getComposerFile()));
        $composerDefinition = $json->read();
        $override = true;

        if (isset($composerDefinition['extra']['tools'][$tool['name']])) {
            $override = $io->askConfirmation(sprintf(
                '<warning>Tool "%s" are already configured in composer.json. Are you sure to override the configuration?</warning>',
                $tool['name']
            ));
        }

        if (false === $override) {
            return 0;
        }

        $composerDefinition['extra']['tools'][$tool['name']] = [
            'url' => $tool['url'],
            'sign-url' => $tool['sign-url'],
            'only-dev' => $tool['only-dev'],
            'force-replace' => $tool['force-replace'],
        ];

        $json->write($composerDefinition);
        $output->write('<info>composer.json are successfully updated! Run "composer update" to get it.</info>');

        return 0;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return array
     */
    private function askQuestions(InputInterface $input, OutputInterface $output)
    {
        $helper = new QuestionHelper;

        $nameQuestion = new NameQuestion;
        $urlQuestion = new UrlQuestion;
        $signUrlQuestion = new SignUrlQuestion;

        $tool = [];
        $tool['name'] = $helper->ask($input, $output, $nameQuestion);
        $tool['url'] = $helper->ask($input, $output, $urlQuestion);
        $tool['sign-url'] = $helper->ask($input, $output, $signUrlQuestion);
        $tool['force-replace'] = $helper->ask($input, $output, new ForceReplaceQuestion);
        $tool['only-dev'] = $helper->ask($input, $output, new OnlyDevQuestion);

        $nameQuestion->saveAutocompleterValues($tool['name']);
        $urlQuestion->saveAutocompleterValues($tool['url']);

        if (!empty($signUrl)) {
            $signUrlQuestion->saveAutocompleterValues($tool['sign-url']);
        }

        return $tool;
    }
}
