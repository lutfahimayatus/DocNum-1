<?php

use Illuminate\Support\Str;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('dashboard'));
});
//User
Breadcrumbs::for('user.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Data User', route('user.index'));
});
Breadcrumbs::for('user.create', function (BreadcrumbTrail $trail,) {
    $trail->parent('user.index');
    $trail->push('Tambah', route('user.create'));
});

Breadcrumbs::for('user.update', function (BreadcrumbTrail $trail, $encryptedId) {
    $trail->parent('user.index');
    $trail->push('Update', route('user.update', $encryptedId));
});

Breadcrumbs::for('cat.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Data Kategori', route('cat.index'));
});
Breadcrumbs::for('cat.create', function (BreadcrumbTrail $trail,) {
    $trail->parent('cat.index');
    $trail->push('Tambah', route('cat.create'));
});

Breadcrumbs::for('cat.update', function (BreadcrumbTrail $trail, $encryptedId) {
    $trail->parent('cat.index');
    $trail->push('Update', route('cat.update', $encryptedId));
});

//Jenis
Breadcrumbs::for('jenis.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Data Jenis', route('jenis.index'));
});
Breadcrumbs::for('jenis.create', function (BreadcrumbTrail $trail,) {
    $trail->parent('jenis.index');
    $trail->push('Tambah', route('jenis.create'));
});

Breadcrumbs::for('jenis.update', function (BreadcrumbTrail $trail, $encryptedId) {
    $trail->parent('jenis.index');
    $trail->push('Update', route('jenis.update', $encryptedId));
});

//Divisi
Breadcrumbs::for('div.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Data Divisi', route('div.index'));
});
Breadcrumbs::for('div.create', function (BreadcrumbTrail $trail,) {
    $trail->parent('div.index');
    $trail->push('Tambah', route('div.create'));
});

Breadcrumbs::for('div.update', function (BreadcrumbTrail $trail, $encryptedId) {
    $trail->parent('div.index');
    $trail->push('Update', route('div.update', $encryptedId));
});

//Document
Breadcrumbs::for('document.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Data Document', route('document.index'));
});
Breadcrumbs::for('searchs.documents', function (BreadcrumbTrail $trail,) {
    $trail->parent('dashboard');
    $trail->push('Data Document', route('searchs.documents'));
});

Breadcrumbs::for('document.update', function (BreadcrumbTrail $trail, $encryptedId) {
    $trail->parent('document.index');
    $trail->push('Update', route('document.update', $encryptedId));
});

//Document
Breadcrumbs::for('log.index', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Log Activity', route('log.index'));
});

//Profile 
Breadcrumbs::for('profile', function (BreadcrumbTrail $trail, $encryptedId) {
    $trail->parent('dashboard');
    $trail->push('Profile');
    $trail->push('Update', route('profile', $encryptedId));
});

Breadcrumbs::for('profile.change.password', function (BreadcrumbTrail $trail, $encryptedId) {
    $trail->parent('dashboard');
    $trail->push('Ganti Kata Sandi');
    $trail->push('Update', route('profile.change.password', $encryptedId));
});

//Employee
Breadcrumbs::for('employee.document', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Data Dokumen', route('employee.document'));
});
Breadcrumbs::for('search.documents', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Data Dokumen', route('search.documents'));
});

Breadcrumbs::for('employee.document.update', function (BreadcrumbTrail $trail, $encryptedId) {
    $trail->parent('dashboard');
    $trail->push('Update', route('employee.document.update', $encryptedId));
});

Breadcrumbs::for('employee.upload', function (BreadcrumbTrail $trail, $encryptedId) {
    $trail->parent('dashboard');
    $trail->push('Upload');
    $trail->push('Update', route('employee.upload', $encryptedId));
});

Breadcrumbs::for('employee.generate', function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('Generate No. Dokumen', route('employee.generate'));
});

Breadcrumbs::for('employee.detail', function (BreadcrumbTrail $trail, $encryptedId) {
    $trail->parent('dashboard');
    $trail->push('Detail');
    $trail->push('Update', route('employee.detail', $encryptedId));
});