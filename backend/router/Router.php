<?php
/** @var Core\Router $router */


// rutas publicas // 
$router->get('', ['HomeController', 'index'], 'home');
$router->get('/login', ['LoginController', 'showForm'], 'login');
$router->post('/login', ['LoginController', 'authenticate']);
$router->post('/logout', ['LoginController', 'logout'], 'logout');

// registro de usuario //
$router->get('/register', ['RegisterController', 'showVerifyForm'], 'register');
$router->post('/register/verify', ['RegisterController', 'verifyDocument'], 'register_verify');
$router->post('/register/complete', ['RegisterController', 'complete'], 'register_complete');
$router->post('/dashboard/users/pre-register', ['RegisterController', 'preRegister'], 'pre_register');

// rutas del dashboard //
$router->get('/dashboard', ['DashboardController', 'index'], 'dashboard');
$router->get('/dashboard/users', ['DashboardController', 'users'], 'dashboard_users');