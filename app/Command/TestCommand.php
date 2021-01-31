<?php

namespace App\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[\Cappa\Di\Annotation\Command(name: "app", desc: "测试命令行")]
class TestCommand extends Command
{
    protected function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if (!$output instanceof ConsoleOutputInterface) {
            throw new \LogicException('This command accepts only an instance of "ConsoleOutputInterface".');
        }

        $section1 = $output->section();
        $section1->writeln('Hello');
        $i = 0;
        while (true) {
            $section1->overwrite('Goodbye: ' . ++$i);
            sleep(1);
        }

        $output->writeln("test 2009" . $input->getArgument('name'));

        return Command::SUCCESS;
    }
}