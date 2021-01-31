<?php
declare(strict_types=1);

use Clock\Kernel;

$kernel = new Kernel();

$kernel->boot();

return $kernel;
