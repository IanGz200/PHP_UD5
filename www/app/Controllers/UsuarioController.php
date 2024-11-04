<?php

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\UsuarioModel;

class UsuarioController extends BaseController{

    public function testConnect() {

        $data = array(
            'titulo' => 'Base de datos',
            'breadcrumb' => ['Inicio','Ejercicio 7', '7-1'],
            'seccion' => '/test-model-7-1'
        );
        $model = new UsuarioModel();
        $data['usuarios']= $model->getUsuarios();

        $this->view->showViews(array('templates/header.view.php', 'ejercicio7.view.php','templates/footer.view.php'), $data);


    }

    public function testConnect2() {

        $data = array(
            'titulo' => 'Base de datos',
            'breadcrumb' => ['Inicio','Ejercicio 7', '7-2'],
            'seccion' => '/test-model-7-2'
        );
        $model = new UsuarioModel();
        $data['usuarios']= $model->getUsuariosOrdenadosMayorAMenorSB();

        $this->view->showViews(array('templates/header.view.php', 'ejercicio7.view.php','templates/footer.view.php'), $data);


    }

    public function testConnect3() {

        $data = array(
            'titulo' => 'Base de datos',
            'breadcrumb' => ['Inicio','Ejercicio 7', '7-3'],
            'seccion' => '/test-model-7-3'
        );
        $model = new UsuarioModel();
        $data['usuarios']= $model->getUsuariosStandar();

        $this->view->showViews(array('templates/header.view.php', 'ejercicio7.view.php','templates/footer.view.php'), $data);


    }

    public function testConnect4() {

        $data = array(
            'titulo' => 'Base de datos',
            'breadcrumb' => ['Inicio','Ejercicio 7', '7-4'],
            'seccion' => '/test-model-7-4'
        );
        $model = new UsuarioModel();
        $data['usuarios']= $model->getUsuariosCarlos();

        $this->view->showViews(array('templates/header.view.php', 'ejercicio7.view.php','templates/footer.view.php'), $data);


    }




}