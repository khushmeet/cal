<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Main');
$routes->setDefaultMethod('login');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.


/*
 * --------------------------------------------------------------------
 * Frontend 
 * --------------------------------------------------------------------
 */
$routes->add('/', 'Main::index');
$routes->add('login', 'Main::login');
$routes->add('main', 'Main::index');
$routes->add('register', 'Main::register');
$routes->add('logout', 'Main::logout');
$routes->add('alltask', 'Tasks::index');
$routes->add('deletetask', 'Tasks::deleteTask');
$routes->add('edittask', 'Tasks::editTask');
$routes->add('showtask', 'Tasks::showTask');
$routes->add('addtask', 'Tasks::addTask');



/*
 * --------------------------------------------------------------------
 * API END POINTS
 * --------------------------------------------------------------------
 */
//Routing
 $routes->group("api", function ($routes) {

 	// user routing
   	$routes->post("register", "API/Users::createUser");
	$routes->post("login",   "API/Users::validateUser");
	$routes->get("userdata", "API/Users::userDetails");

	// Schedule routing
	$routes->get('get-schedule', 'API/Schedule::index');
	$routes->get('show-schedule', 'API/Schedule::show');
	$routes->post('update-schedule', 'API/Schedule::update');
	$routes->post('create-schedule', 'API/Schedule::insert');
	$routes->get('delete-schedule', 'API/Schedule::delete');

 });

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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
