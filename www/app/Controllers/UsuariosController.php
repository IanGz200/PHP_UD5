<?php

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;

class UsuariosController extends BaseController
{

    public function showNewUsuario(): void {

        $data = array(
            'titulo' => 'Ejercicio 1 del apartado 3',
            'breadcrumb' => ['Inicio', 'Ejercicio 1'],
            'seccion' => '/ejercicio1'
        );
        $this->view->showViews(array('templates/header.view.php', 'ejercicio1.view.php','templates/footer.view.php'), $data);

    }
}