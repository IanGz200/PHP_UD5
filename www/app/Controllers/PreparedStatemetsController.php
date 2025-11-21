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

    public function alta(): void
    {

        $model = new ConsultasModel();

        $errors = $model->checkErrors($_POST);
        if ($errors !== []) {
            $this->newTrabajador($errors, filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        } else {
            if ($model->insert($_POST)) {
                header('location: /prepared');
            } else {
                $this->newTrabajador(
                    ['username' => 'Error indeterminado al guardar'],
                    filter_var_array($_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS)
                );
            }
        }
    }
    public function newTrabajador(array $errors = [], array $input = []): void
    {
        $auxRolModel = new AuxRolModel();
        $roles = $auxRolModel->getAll();
        $countryModel = new AuxCountryModel();
        $countries = $countryModel->getAll();
        $data = [
            'titulo' => 'Alta trabajador',
            'breadcumb' => ['Inicio', 'Trabajadores', 'Alta'],
            'roles' => $roles,
            'countries' => $countries,
            'errors' => $errors,
            'input' => $input
        ];
        $this->view->showViews(
            array('templates/header.view.php', 'prepared_stmt.edit.view.php', 'templates/footer.view.php'),
            $data
        );
    }
}
