<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;

class InsertionController extends BaseController
{
    public function alta()
    {
        $copiaGet = $_GET;
        $queryParams = http_build_query($copiaGet);

        $data = [
            'titulo' => 'Alta',
            'breadcrumb' => ['Inicio', 'Edit DataBase', 'Alta'],
            'input' => $_GET,
            'url' => '/edit?' . $queryParams,
        ];
        $this->view->showViews(
            array('templates/header.view.php', 'insertion.view.php', 'templates/footer.view.php'),
            $data,
        );
    }
}
