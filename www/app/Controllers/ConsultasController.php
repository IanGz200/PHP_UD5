<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\ConsultasModel;

class ConsultasController extends BaseController
{
    public function getTrabajadores()
    {
        $model = new ConsultasModel();
        $trabajadores = $model->getAll();
    }

    public function getTrabajadoresBySalary()
    {
        $model = new ConsultasModel();
        $trabajadoresBySalary = $model->getAllBySalary();
    }

    public function getTrabajadoresStandard()
    {
        $model = new ConsultasModel();
        $trabajadores = $model->getStandard();
    }

    public function getCarlos()
    {
        $model = new ConsultasModel();
        $trabajadores = $model->getCarlos();
    }
}
