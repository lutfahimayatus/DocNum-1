<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('beranda', function (BreadcrumbTrail $trail) {
    $trail->push('Beranda', route('dashboard'));
});

Breadcrumbs::for('user', function (BreadcrumbTrail $trail) {
    $trail->parent('beranda');
    $trail->push('Data User', route('user.index'));
});