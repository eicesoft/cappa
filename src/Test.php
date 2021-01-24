<?php
declare(strict_types=1);

namespace Cappa;


use Cappa\Di\Annotation\Autowiring;
use Cappa\Di\Annotation\Component;

#[Component(lazy: false)]
class Test
{
    #[Autowiring]
    private Logger $log;

    private $name;

    public function test()
    {
//        var_dump($this);
        return '2009';
    }
}