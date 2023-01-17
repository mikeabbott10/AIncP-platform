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
$routes->setDefaultController('Auth');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
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

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'AuthController::index');
$routes->post('/', 'AuthController::index');
$routes->get('logout', 'AuthController::logout');
$routes->get('dashboard', 'SubjectsController::index'); // index dashboard page

$routes->get('dashboard/subject/add', 'SubjectsController::add_subject'); // add subject page
$routes->get('dashboard/subject', 'SubjectsController::index'); // all subjects overview page
$routes->get('dashboard/subject/(:num)', 'SubjectsController::subject_card/$1'); // subject (:num) overview page
$routes->get('dashboard/subject/delete/(:num)', 'SubjectsController::delete_subject/$1');
$routes->post('dashboard/subject/upload', 'SubjectsController::upload_subject_data'); // perform new subject data insert
$routes->post('dashboard/subject/(:num)/upload', 'SubjectsController::upload_subject_data/$1'); // perform existing subject data update


$routes->get('dashboard/subject/(:num)/sessions', 'SessionsController::index/$1');
$routes->get('dashboard/subject/(:num)/sessions/add', 'SessionsController::add_session/$1');
$routes->get('dashboard/subject/(:num)/sessions/delete/(:num)', 'SessionsController::delete_session/$1/$2');


$routes->get('dashboard/upload', 'UploadController::index'); // upload file page
$routes->post('dashboard/upload/upload', 'UploadController::upload'); // perform upload

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
