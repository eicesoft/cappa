<?php
declare(strict_types=1);


namespace Cappa\Di;


interface ContainerInterface
{

    public function get(string $id);

    public function has(string $id);

    public function make(string $id, array $parameters = []);

    public function put($object);
}