<?php
declare(strict_types=1);

namespace Cappa;


use Cappa\Command\CommandManager;
use Cappa\Di\ArrayContainer;
use Cappa\Di\Container;
use Cappa\Http\Request\Request;
use Cappa\Loader\ClassLoader;
use Exception;
use Sms\Http\Controller\IndexController;
use Symfony\Component\Console\Application;

class Cappa
{
    private array $app_config = [];

    private array $check_config_keys = [
        'ROOT_PATH'
    ];

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

        $application = Container::get()->make(Http\Application::class);
        $response = $application->handle($request = Request::capture());
//        $index = new IndexController();
//        dd($index);
        return $application->terminate($request, $response);
    }

    /**
     * @throws Exception
     */
    public function cli()
    {
        $this->init();

        $application = new Application();
        CommandManager::inject($application);   //动态注入命令行
        $application->run();
    }

    /**
     * @param array $app_config
     * @return Cappa
     */
    public function config(array $app_config): Cappa
    {
        foreach ($this->check_config_keys as $key) {
            if (!isset($app_config[$key])) {
                trigger_error('System running must be app config key: ' . $key, E_USER_NOTICE);
            }
        }

        $this->app_config = $app_config;

        foreach ($this->app_config as $key => $value) {
            $upper_key = strtoupper($key);
            if (!defined($upper_key)) {
                define($upper_key, $value);
            }
        }

        return $this;
    }

    public function get($key = null, $default = null)
    {
        if (null === $key) {
            return $this->app_config;
        } else {
            return $this->app_config[$key] ?? $default;
        }
    }

    /**
     * 初始化Env环境
     */
    private function initEnvs()
    {
        $this->loadEnv();
        $this->loadEnv(env('APP_MODE', 'dev'));
    }

    /**
     * @param string $mode
     */
    private function loadEnv(string $mode = '')
    {
        $env_file = realpath('./') . '/.env';

        if ($mode !== '') {
            $env_file .= '.' . $mode;
        }

        if (is_readable($env_file)) {
            $envs = parse_ini_file($env_file);
            foreach ($envs as $key => $val) {
                putenv("{$key}={$val}");
            }
        }
    }

    /**
     * 系统初始化
     */
    private function init()
    {
        $this->initEnvs();
        $this->initCore();
        $this->scan();
    }

    /**
     * 初始化内核
     */
    private function initCore()
    {
        $run_mode = env('RUN_MODE', 'dev');

        if ($run_mode === 'dev') {
            error_reporting(E_ALL);
            ini_set('display_errors', 'on');
        } else {
            error_reporting(0);
            ini_set('display_errors', 'off');
        }

        $timezone = env('TIME_ZONE', 'UTC');
        date_default_timezone_set($timezone);

        ErrorHandler::registry();
    }

    /**
     * @param callable $handler
     * @return $this
     */
    public function add_error_handler(callable $handler): Cappa
    {
        ErrorHandler::addHandler($handler);

        return $this;
    }

    public function scan()
    {
        foreach ($this->scan_paths as $scan_path) {
            $class = new ClassLoader($scan_path);
        }
    }

    /**
     * @param string $scan_path
     * @return Cappa
     */
    public function scan_path(string $scan_path): Cappa
    {
        if (!in_array($scan_path, $this->scan_paths)) {
            $this->scan_paths[] = $scan_path;
        }

        return $this;
    }
}