<?php


namespace Cappa\Provider;


abstract class ServiceProvider
{
    protected string $name = '';

    public function boot()
    {
        if ($this->name === '') {
            $this->name = get_called_class();
        }
    }

    public abstract function register();
}