<?php
declare(strict_types=1);

namespace Cappa\Loader;


use Cappa\Di\Container;
use Cappa\Di\Reflection\ReflectionManager;

class ClassLoader
{

    private string $path;

    /**
     * ClassLoader constructor.
     * @param $path
     */
    public function __construct($path)
    {
        $this->path = $path;

        $file_items = $this->glob($this->path);
        foreach ($file_items as $file_item) {
            $this->resolved($file_item);
        }
    }

    /**
     * @param string $filename
     */
    public function resolved(string $filename)
    {
        $content = file_get_contents($filename);
        $namespace_preg = '/namespace\ (.*)\;/';
        $class_preg = "/class\ (\w+)/";

        if (preg_match($class_preg, $content, $class_matches) && preg_match($namespace_preg, $content, $namespace_matches)) {
            $base_classname = $class_matches[1];
            $namespace_name = $namespace_matches[1];
            $class_name = $namespace_name . '\\' . $base_classname;

            Container::get()->make($class_name);
        }

//        $this->container()->make($class_name);

//        $class_preg = "/interface\ (\w+)/";
//        if (preg_match($class_preg, $content, $class_matches) && preg_match($namespace_preg, $content, $namespace_matches)) {
//            $base_interface_name = $class_matches[1];
//            $namespace_name = $namespace_matches[1];
//            $class_name = $namespace_name . '\\' . $base_interface_name;
//            ReflectionManager::create($class_name);
//        }
//
//        $class_preg = "/trait\ (\w+)/";
//        if (preg_match($class_preg, $content, $class_matches) && preg_match($namespace_preg, $content, $namespace_matches)) {
//            $base_trait_name = $class_matches[1];
//            $namespace_name = $namespace_matches[1];
//            $class_name = $namespace_name . '\\' . $base_trait_name;
//            ReflectionManager::create($class_name);
//        }
    }

    /**
     * 过滤文件
     * @param string $path
     * @param string $ext
     * @return array
     */
    public function glob($path, $ext = '*'): array
    {
        $fileItem = [];
        foreach (glob($path . DIRECTORY_SEPARATOR . $ext) as $v) {
            $newPath = $v;
            if (is_dir($newPath)) {
                $fileItem = array_merge($fileItem, $this->glob($newPath));
            } else if (is_file($newPath)) {
                $fileItem[] = $newPath;
            }
        }

        return $fileItem;
    }
}