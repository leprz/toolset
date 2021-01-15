<?php

declare(strict_types=1);

use Persistence\Kernel;
use Pimple\Container;

$kernel = new Kernel(new Container());

$kernel->boot();

return $kernel;
