<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('User');
$routes->setDefaultMethod('home');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// DASHBOARD ADMIN
$routes->get('/dashboard', 'Dashboard::dashboard');
// $routes->get('/dashboard-superuser', 'Admin::admin_list');
$routes->post('/addcategory', 'Dashboard::addcategory');
$routes->post('/editcategory', 'Dashboard::editcategory');
$routes->post('/deletecategory', 'Dashboard::deletecategory');

// KUMPULAN ARTIKEL ADMIN
$routes->get('/article/(:num)', 'Article::article/$1');
$routes->get('/addarticle', 'Article::addarticle');
$routes->post('/deletearticle', 'Article::deletearticle');
$routes->post('/savearticle', 'Article::savearticle');
$routes->get('/editarticle/(:num)', 'Article::editarticle/$1');
$routes->post('/updatearticle', 'Article::updatearticle');

// DAFTAR ADMIN
$routes->get('/adminlist', 'Admin::admin_list');

// LOGIN DAN LOGOUT
$routes->get('/login-admin', 'Auth::index');
$routes->post('register', 'Auth::processRegistration');
$routes->get('logout', 'Auth::logout');

$routes->get('exportpdf', 'Dashboard::exportpdf');

$routes->post('/forgot-password', 'Auth::sendPasswordResetEmail');
// $routes->get('admin/toggleAdminStatus/(:num)/(:alpha)', 'Admin::toggleAdminStatus/$1/$2');
// $routes->get('admin/toggleKategoriStatus/(:num)/(:alpha)', 'Admin::toggleKategoriStatus/$1/$2');




/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

