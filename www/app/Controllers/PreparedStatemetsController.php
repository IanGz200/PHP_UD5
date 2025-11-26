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
        unset($copiaGet['page']);
        $queryParamsPage = http_build_query($copiaGet);
        unset($copiaGet['order']);
        $queryParams = http_build_query($copiaGet);
        $pageMax = $model->getNumPages($_GET);

        $data = [
            'titulo' => 'Prepared Statemets',
            'breadcrumb' => ['Inicio', 'Prepared Statemets'],
            'trabajadores' => $consulta,
            'input' => filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS),
            'roles' => $roles,
            'paises' => $paises,
            'url' => '/prepared?' . $queryParams,
            'urlPage' => '/prepared?' . $queryParamsPage,
            'order' => $model->getOrderInt($_GET),
            'page' => $model->getPage($_GET),
            'pageMax' => $pageMax
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

    public function update(string $username, array $input = [], array $errors = []): void
    {
        $consultasModel = new ConsultasModel();
        $usuario = $consultasModel->find($username);
        if ($usuario === false) {
            header('location: /prepared');
        } else {
            $auxRolModel = new AuxRolModel();
            $roles = $auxRolModel->getAll();
            $auxCountryModel = new AuxCountryModel();
            $auxCountry = $auxCountryModel->getAll();
            $data = [
                'titulo' => 'Actualizar trabajador',
                'breadcrumb' => ['Incio', 'Editar trabajadores', 'Actualizar trabajador'],
                'roles' => $roles,
                'paises' => $auxCountry,
                'errors' => $errors,
                'input' => $input !== [] ? $input : $usuario,
            ];

            $this->view->showViews(
                array('templates/header.view.php', 'prepared_stmt.edit.view.php', 'templates/footer.view.php'),
                $data
            );

        }
    }

    public function modoOscuro()
    {
        $modo = ['oscuro','claro'];
        if (in_array($_POST['modo'], $modo)) {
            setcookie('modo', $_POST['modo'], time() + (86400 * 30));
            $_COOKIE['modo'] = $_POST['modo'];
        }

        $data = [
            'titulo' => 'Modo Oscuro',
            'breadcumb' => ['Inicio', 'Modo Oscuro']
        ];
        $this->view->showViews(
            array('templates/header.view.php', 'modo.view.php', 'templates/footer.view.php'),
            $data
        );
    }
}
