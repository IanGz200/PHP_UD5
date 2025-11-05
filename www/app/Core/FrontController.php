<?php

namespace Com\Daw2\Core;

use Com\Daw2\Controllers\ErroresController;
use Com\Daw2\Controllers\InicioController;
use Com\Daw2\Controllers\ConsultasController;
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
                $controlador->index();
            },
            'get'
        );

        Route::add(
            '/',
            function () {
                $controlador = new ConsultasController();
                $controlador->index();
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
