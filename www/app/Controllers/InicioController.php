<?php
declare(strict_types = 1);
namespace Com\Daw2\Controllers;

class InicioController extends \Com\Daw2\Core\BaseController {

    public function index() {
        $data = array(
            'titulo' => 'Página de inicio',
            'breadcrumb' => ['Inicio'],
            'seccion' => '/inicio'
        );        
        $this->view->showViews(array('templates/header.view.php', 'inicio.view.php', 'templates/footer.view.php'), $data);
    }
    
    public function demo() {
        $data = array(
            'titulo' => 'Demo html proveedores',
            'breadcrumb' => ['Inicio', 'Demo proveedores'],
            'seccion' => '/demo-proveedores'
        );        
        $this->view->showViews(array('templates/header.view.php', 'proveedores.sample.php', 'templates/footer.view.php'), $data);
    }
    public function prueba() {
        $data = array(
            'titulo' => 'prueba',
            'breadcrumb' => ['Inicio', 'prueba'],
            'seccion' => '/prueba'
        );
        $this->view->showViews(array('templates/header.view.php', 'provincias.sample.php', 'templates/footer.view.php'), $data);
    }

    public function ejer() {
        $data = array(
            'titulo' => 'Ejercicio 1 del apartado 3',
            'breadcrumb' => ['Inicio', 'Ejercicio 1'],
            'seccion' => '/ejercicio1'
        );
        $this->view->showViews(array('templates/header.view.php', 'ejercicio1.view.php','templates/footer.view.php'), $data);

    }
}
