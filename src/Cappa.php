<?php
declare(strict_types=1);

namespace Cappa;


use Cappa\Loader\ClassLoader;

class Cappa
{
    /**
     * @var Cappa|null
     */
    private static ?Cappa $instance = null;

    /**
     * @return Cappa
     */
    public static function Instance(): Cappa
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * @var array
     */
    private array $scan_paths = [];


    public function __construct()
    {
        $this->scan_paths[] = __DIR__;
    }

    public function execute()
    {
        $this->init();
    }

    /**
     *
     */
    private function init()
    {
        $this->scan();
    }

    public function scan()
    {
        foreach ($this->scan_paths as $scan_path) {
            $class = new ClassLoader($scan_path);
        }
    }

    /**
     * @param string $scan_path
     */
    public function add_scan_paths(string $scan_path)
    {
        if (!in_array($scan_path, $this->scan_paths)) {
            $this->scan_paths[] = $scan_path;
        }
    }
}