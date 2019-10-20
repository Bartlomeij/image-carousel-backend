<?php

namespace App\Command\Cli;

use App\Command\GenerateImageListFileFromCsvCommand;
use App\Factory\FileFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;

class CarouselGenerateCommand extends Command
{
    protected static $defaultName = 'carousel:generate';

    /**
     * @var MessageBusInterface
     */
    private $commandBus;

    /**
     * CarouselGenerateCommand constructor.
     * @param MessageBusInterface $commandBus
     */
    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Generate images list json or xml file from csv file')
            ->addArgument('filepath', InputArgument::REQUIRED, 'Absolute csv file path')
            ->addOption('format', '--format', InputOption::VALUE_OPTIONAL, 'Generated file format')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $symfonyStyleIO = new SymfonyStyle($input, $output);

        try {
            $this->commandBus->dispatch(
                new GenerateImageListFileFromCsvCommand(
                    $input->getOption('format') ?? FileFactory::JSON_FILE_TYPE,
                    $input->getArgument('filepath'),
                )
            );
            $symfonyStyleIO->success('File generated.');
        } catch (HandlerFailedException $exception) {
            $symfonyStyleIO->error($exception->getMessage());
        }
    }
}
