<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Tickets';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Rutas personalizadas
$route['login']['POST']		=	'auth/login_post';
$route['login']			=	'auth/login';
$route['logout']		=	'auth/logout';


//Rutas para POST ABM
$route['usuarios/alta']['POST']		=   'usuarios/alta_post';
$route['abonados/alta']['POST']		=	'abonados/alta_post';

//Rutas de AJAX
$route['ajax/abonados/buscar']['GET']		=   'ajax/buscarAbonados';
$route['ajax/usuarios/buscar']['GET']		=   'ajax/buscarUsuarios';
$route['ajax/usuarios']['GET']				=   'ajax/usuariosPorFiltros';
$route['ajax/tickets/buscar']['GET']		=   'ajax/buscarTickets';


