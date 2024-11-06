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

    public function testConnect5()
    {

        $data = array(
            'titulo' => 'Base de datos',
            'breadcrumb' => ['Inicio', 'Ejercicio 8', '8-1'],
            'seccion' => '/Ejercicio-8-1'
        );
        $model = new UsuarioModel();

        $data['input'] = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!empty($_GET['username'])) {
            $data['usuarios'] = $model->getUsuariosFilteredUsername($_GET['username']);
        }else if(!empty($_GET['rol'])){
            $data['usuarios'] = $model->getUsuariosFilteredRol($_GET['rol']);
        }else if(!empty($_GET['nacionalidad'])){
            $data['usuarios'] = $model->getUsuariosFilteredNacionalidad($_GET['nacionalidad']);
        }else if(!empty($_GET['salar'])){
            $data['usuarios'] = $model->getUsuariosFilteredSalar((int)$_GET['min_salar'], (int)$_GET['max_salar']);
        }else{
            $data['usuarios'] = $model->getUsuarios();
        }
        $this->view->showViews(array('templates/header.view.php', 'ejercicio8.view.php', 'templates/footer.view.php'), $data);


    }




}