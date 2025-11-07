<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\ConsultasModel;

class ConsultasController extends BaseController
{
    public function set($consulta): void
    {
        $data = [
            'titulo' => 'Consultas',
            'breadcrumb' => ['Inicio', 'Consultas'],
            'trabajadores' => $consulta
        ];
        $this->view->showViews(
            array('templates/header.view.php', 'consultas.view.php', 'templates/footer.view.php'),
            $data,
        );
    }

    public function getTrabajadores(): void
    {
        $model = new ConsultasModel();
        $this->set($model->getAll());
    }

    public function getTrabajadoresBySalary(): void
    {
        $model = new ConsultasModel();
        $this->set($model->getAllBySalary());
    }

    public function getTrabajadoresStandard(): void
    {
        $model = new ConsultasModel();
        $this->set($model->getStandard());
    }

    public function getCarlos(): void
    {
        $model = new ConsultasModel();
        $this->set($model->getCarlos());
    }
}
