<?php

namespace Com\Daw2\Core;

use Com\Daw2\Controllers\ErroresController;
use Com\Daw2\Controllers\InicioController;
use Com\Daw2\Controllers\UsuariosController;
use Steampixel\Route;

class FrontController
{
    public static function main(): void
    {
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

        Route::add(
            '/ejercicio1',
            function () {
                $controlador = new InicioController();
                $controlador->ejer();
            },
            'get'
        );

        Route::add(
            '/usuarios/new',
            function () {
                $controlador = new UsuariosController();
                $controlador->showNewUsuario();

            }
        );

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
        Route::run($_ENV['HOST.FOLDER']);
    }
}
