<?php
// Home
Breadcrumbs::register('Home', function($breadcrumbs)
{
    $breadcrumbs->push('Home', route('admin.stores.index'));
});

// Customer
Breadcrumbs::register('Customer', function($breadcrumbs)
{
    $breadcrumbs->parent('Home');
    $breadcrumbs->push('Customer', route('admin.customers.index'));
});
// Store
Breadcrumbs::register('Store', function($breadcrumbs)
{
    $breadcrumbs->parent('Home');
    $breadcrumbs->push('Store', route('admin.stores.index'));
});
// StoreCategories
Breadcrumbs::register('StoreCategories', function($breadcrumbs)
{
    $breadcrumbs->parent('Home');
    $breadcrumbs->push('StoreCategories', route('admin.storeCategories.index'));
});
// Uom
Breadcrumbs::register('Uom', function($breadcrumbs)
{
    $breadcrumbs->parent('Home');
    $breadcrumbs->push('UOM', route('admin.uoms.index'));
});
// ProductCategories
Breadcrumbs::register('ProductCategories', function($breadcrumbs)
{
    $breadcrumbs->parent('Home');
    $breadcrumbs->push('Product Categories', route('admin.productCategories.index'));
});
// Product
Breadcrumbs::register('Product', function($breadcrumbs)
{
    $breadcrumbs->parent('Home');
    $breadcrumbs->push('Product', route('admin.products.index'));
});
// Order
Breadcrumbs::register('Order', function($breadcrumbs)
{
    $breadcrumbs->parent('Home');
    $breadcrumbs->push('Order', route('admin.orders.index'));
});
// Home > About
Breadcrumbs::register('about', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('About', route('about'));
});

// Home > Blog
Breadcrumbs::register('blog', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Blog', route('blog'));
});

// Home > Blog > [Category]
Breadcrumbs::register('category', function($breadcrumbs, $category)
{
    $breadcrumbs->parent('blog');
    $breadcrumbs->push($category->title, route('category', $category->id));
});

// Home > Blog > [Category] > [Page]
Breadcrumbs::register('page', function($breadcrumbs, $page)
{
    $breadcrumbs->parent('category', $page->category);
    $breadcrumbs->push($page->title, route('page', $page->id));
});
/*
*--for rendering------
{!! Breadcrumbs::render('home') !!}

{!! Breadcrumbs::render('category', $category) !!}
*
*/