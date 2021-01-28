<?php
declare(strict_types=1);

namespace Cappa\Command;


use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;

/**
 * Class CommandManager
 * @package Cappa\Command
 */
class CommandManager
{
    private static array $commands = [];

    /**
     * @param Command $command
     * @param string $name
     * @param string $desc
     */
    public static function add(Command $command, $name = '', $desc = '')
    {
        $command->setName($name);
        $command->setDescription($desc);

        self::$commands[] = $command;
    }

    /**
     * @param Application $application
     */
    public static function inject(Application $application)
    {
        foreach (self::$commands as $command) {
            $application->add($command);
        }
    }
}