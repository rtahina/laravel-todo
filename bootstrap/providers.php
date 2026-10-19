<?php

use App\Providers\AppServiceProvider;
use App\Providers\DomainServiceProvider;
use App\Providers\FortifyServiceProvider;
use App\Providers\NotificationProvider;

return [
    AppServiceProvider::class,
    DomainServiceProvider::class,
    FortifyServiceProvider::class,
    NotificationProvider::class,
];
