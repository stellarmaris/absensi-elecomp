<?php

use App\Controllers\AuthController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(true);
$routes->get('/', 'AuthController::login');
$routes->get('/home', 'Home::index');
$routes->get('/signUp', 'AuthController::signUp');
$routes->post('/signUp', 'AuthController::tambahUser');
$routes->get('/riwayat', 'historyUserController::riwayat');

$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::authenticate');

$routes->get('/izin-form', 'IzinController::index');
$routes->post('/izin-form', 'IzinController::store');

$routes->get('/check-in-form', 'CheckInController::index');
$routes->post('/check-in-form', 'CheckInController::store');
$routes->get('/checkout', 'CheckoutController::index');
$routes->post('/checkout', 'CheckoutController::checkout');
$routes->get('/success-check-in', 'SuccesCheckInController::index');
$routes->get('/pending-check-in', 'PendingCheckInController::index');
$routes->get('/success-izin', 'SuccesIzinController::index');
$routes->get('/success-checkout', 'SuccessCheckoutController::index');


$routes->get('/lokasiSemua', 'LokasiController::index');
$routes->get('/logout', 'AuthController::logout');

$routes->get('/user-list', 'UserListController::index');
$routes->get('/detail-user/(:num)', 'UserListController::detail/$1');
$routes->get('/detail-user/edit-user/(:num)', 'UserListController::edit/$1');
$routes->post('/detail-user/update-user/(:num)', 'UserListController::update/$1');
$routes->get('/trouble-form', 'TroubleFormController::index');
$routes->get('/help-support', 'HelpSupportController::index');
$routes->post('delete-user/(:num)', 'UserListController::delete/$1');

$routes->post('/deleteFoto','deleteFotoController::deleteAll');
$routes->post('/markAlpha','MarkAlphaController::markAlpha');
$routes->get('/summary-presensi','SummaryPresensiController::index');
$routes->get('RekapitulasiAbsen/updateStatusAlpha/(:num)', 'MarkAlphaController::updateStatusAlpha/$1');

