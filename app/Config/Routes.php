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
service('auth')->routes($routes);

$routes->get('/', 'SubjectsController::index'); // index dashboard page
$routes->get('logout', 'SubjectsController::logoutAction'); // index dashboard page


$routes->get('dashboard/subject/add', 'SubjectsController::add_subject'); // add subject page
$routes->post('dashboard/subject/upload', 'SubjectsController::upload_subject_data'); // perform new subject data insert
$routes->get('dashboard/subject', 'SubjectsController::index'); // all subjects overview page
$routes->get('dashboard/subject/(:num)', 'SubjectsController::subject_card/$1'); // subject (:num) overview page
$routes->post('dashboard/subject/(:num)/upload', 'SubjectsController::upload_subject_data/$1'); // perform existing subject data update
$routes->get('dashboard/subject/delete/(:num)', 'SubjectsController::delete_subject/$1');


$routes->get('dashboard/subject/(:num)/session/add', 'SessionsController::add_session/$1');
$routes->post('dashboard/subject/(:num)/session/upload_session', 'SessionsController::upload_session_data/$1');
$routes->post('dashboard/subject/(:num)/session/upload_file', 'SessionsController::upload_file/$1');
$routes->get('dashboard/subject/(:num)/session/getData/(:num)/(:num)', 'SessionsController::get_plot_data/$1/$2/$3');
$routes->get('dashboard/subject/(:num)/session/getData', 'SessionsController::get_plot_data/$1');
$routes->get('dashboard/subject/(:num)/session', 'SessionsController::index/$1');
$routes->get('dashboard/subject/(:num)/session/delete/(:num)', 'SessionsController::delete_session/$1/$2');


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
