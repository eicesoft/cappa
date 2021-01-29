<?php
declare(strict_types=1);

namespace Cappa\Http;


use Cappa\Di\Annotation\Autowiring;
use Cappa\Di\Annotation\Component;

#[Component]
class BaseController
{
    #[Autowiring]
    protected Context $context;

    /**
     * @return Context
     */
    public function getContext(): Context
    {
        return $this->context;
    }
}