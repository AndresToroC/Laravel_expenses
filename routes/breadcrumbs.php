<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Usuarios
Breadcrumbs::for('users', function (BreadcrumbTrail $trail) {
    $trail->push('Usuarios', route('admin.users.index'));
});

Breadcrumbs::for('users.create', function (BreadcrumbTrail $trail) {
    $trail->parent('users');
    $trail->push('Crear Usuario', route('admin.users.create'));
});

Breadcrumbs::for('users.edit', function (BreadcrumbTrail $trail, $user) {
    $trail->parent('users');
    $trail->push('Editar Usuario', route('admin.users.edit', $user));
});

// Categorias
Breadcrumbs::for('categories', function (BreadcrumbTrail $trail) {
    $trail->push('Categorias', route('admin.categories.index'));
});

Breadcrumbs::for('categories.create', function (BreadcrumbTrail $trail) {
    $trail->parent('categories');
    $trail->push('Crear Categoría', route('admin.categories.create'));
});

Breadcrumbs::for('categories.edit', function (BreadcrumbTrail $trail, $category) {
    $trail->parent('categories');
    $trail->push('Editar Categoría', route('admin.categories.edit', $category));
});

// Sub categorias
Breadcrumbs::for('categories.subCategories', function (BreadcrumbTrail $trail, $category) {
    $trail->parent('categories');
    $trail->push($category->name, route('admin.categories.subCategories.index', $category));
});

Breadcrumbs::for('categories.subCategories.create', function (BreadcrumbTrail $trail, $category) {
    $trail->parent('categories.subCategories', $category);
    $trail->push('Crear Sub-Categoría', route('admin.categories.subCategories.create', $category));
});

Breadcrumbs::for('categories.subCategories.edit', function (BreadcrumbTrail $trail, $category, $subCategory) {
    $trail->parent('categories.subCategories', $category);
    $trail->push('Editar Sub-Categoría', route('admin.categories.subCategories.edit', [$category, $subCategory]));
});

// Movimientos
Breadcrumbs::for('movements', function (BreadcrumbTrail $trail, $date = '') {
    $trail->push('Movimientos', route('movements.index', $date));
});

Breadcrumbs::for('movements.create', function (BreadcrumbTrail $trail, $date = '') {
    $trail->parent('movements', ['date' => $date]);
    $trail->push('Crear Movimiento', route('movements.create', $date));
});

Breadcrumbs::for('movements.edit', function (BreadcrumbTrail $trail, $date = '', $movement) {
    $trail->parent('movements', ['date' => $date]);
    $trail->push('Editar Movimiento', route('movements.edit', [$date, $movement]));
});