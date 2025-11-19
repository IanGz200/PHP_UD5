<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\AuxCountryModel;
use Com\Daw2\Models\AuxRolModel;
use Com\Daw2\Models\ConsultasModel;
use MyProject\Container;

class PreparedStatemetsController extends BaseController
{
    public function get(): void
    {
        $model = new ConsultasModel();
        $consulta = $model->getFilteredUsers($_GET);

        $aux_rol = new AuxRolModel();
        $roles = $aux_rol->getAll();

        $aux_country = new AuxCountryModel();
        $paises = $aux_country->getAll();

        $copiaGet = $_GET;
        $page = $copiaGet['page'] ?? 1;
        unset($copiaGet['order']);
        $queryParams = http_build_query($copiaGet);


        $data = [
            'titulo' => 'Prepared Statemets',
            'breadcrumb' => ['Inicio', 'Prepared Statemets'],
            'trabajadores' => $consulta,
            'input' => $_GET,
            'roles' => $roles,
            'paises' => $paises,
            'url' => '/prepared?' . $queryParams,
            'order' => $model->getOrderInt($_GET),
        ];
        $this->view->showViews(
            array('templates/header.view.php', 'prepared_stmt.view.php', 'templates/footer.view.php'),
            $data,
        );
    }
}
