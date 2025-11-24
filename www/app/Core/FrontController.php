<?php

namespace Com\Daw2\Core;

use Com\Daw2\Controllers\ErroresController;
use Com\Daw2\Controllers\InicioController;
use Com\Daw2\Controllers\ConsultasController;
use Com\Daw2\Controllers\InsertionController;
use Com\Daw2\Controllers\PreparedStatemetsController;
use Steampixel\Route;

class FrontController
{
    public static function main(): void
    {
        /**
         * Por defecto
         */
        Route::add(
            '/',
            function () {
                $controlador = new InicioController();
                $controlador->index();
            },
            'get'
        );

        Route::add(
            '/demo-proveedores',
            function () {
                $controlador = new InicioController();
                $controlador->demo();
            },
            'get'
        );

        /**
         * Ejercicios Consultas
         */

        Route::add(
            '/consultas',
            function () {
                $controlador = new ConsultasController();
                $controlador->getTrabajadores();
            },
            'get'
        );

        Route::add(
            '/consultas',
            function () {
                $controlador = new ConsultasController();
                $controlador->getTrabajadores();
            },
            'post'
        );

        /**
         * Prepared statements con filtros
         */

        Route::add(
            '/prepared',
            function () {
                $controlador = new PreparedStatemetsController();
                $controlador->get();
            },
            'get'
        );

        Route::add(
            '/prepared',
            function () {
                $controlador = new PreparedStatemetsController();
                $controlador->get();
            },
            'post'
        );

        /**
         * Modificar Base de datos
         */

        Route::add(
            '/prepared/edit/alta',
            function () {
                $controlador = new PreparedStatemetsController();
                $controlador->newTrabajador();
            },
            'get'
        );
        Route::add(
            '/prepared/edit/alta',
            function () {
                $controlador = new PreparedStatemetsController();
                $controlador->alta();
            },
            'post'
        );

        Route::add(
            '/prepared/edit/baja',
            function () {
                $controlador = new PreparedStatemetsController();
                $controlador->baja();
            },
            'get'
        );
        Route::add(
            '/prepared/edit/baja',
            function () {
                $controlador = new PreparedStatemetsController();
                $controlador->baja();
            },
            'post'
        );

        Route::add(
            '/prepared/edit/modificacion/(\w{4,50})',
            function () {
                $controlador = new PreparedStatemetsController();
                $controlador->modificacion($username);
            },
            'get'
        );

        Route::add(
            '/prepared/edit/modificacion/(\w{4,50})',
            function () {
                $controlador = new PreparedStatemetsController();
                $controlador->modificacion($username);
            },
            'get'
        );

        /**
         * Modo Oscuro
         */

        Route::add(
            '/modo',
            function () {
                $controlador = new PreparedStatemetsController();
                $controlador->modoOscuro();
            },
            'get'
        );

        Route::add(
            '/modo',
            function () {
                $controlador = new PreparedStatemetsController();
                $controlador->modoOscuro();
            },
            'post'
        );

        /**
         * Errores
         */
        Route::pathNotFound(
            function () {
                $controller = new ErroresController();
                $controller->error404();
            }
        );

        Route::methodNotAllowed(
            function () {
                $controller = new ErroresController();
                $controller->error405();
            }
        );
        Route::run($_ENV['host.folder']);
    }
}
