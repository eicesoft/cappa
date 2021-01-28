<?php
declare(strict_types=1);

namespace App\Providers;


use Cappa\Di\Annotation\Component;
use Cappa\Provider\ServiceProvider;
use Composer\Autoload\ClassLoader;

#[Component]
class ModuleServiceProvider extends ServiceProvider
{
    private array $modules = [
        'Sms\\' => 'Sms'
    ];

    public function register()
    {
        $classloader = new ClassLoader();
        foreach ($this->modules as $prefix => $module) {
            $classloader->setPsr4($prefix, ROOT_PATH . '/app/Modules/' . $module);
        }

        $classloader->register();
        $classloader->setUseIncludePath(true);

        foreach ($this->modules as $prefix => $module) {
            new \Cappa\Loader\ClassLoader(ROOT_PATH . '/app/Modules/' . $module);
        }
    }
}