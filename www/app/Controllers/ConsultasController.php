<?php

declare(strict_types=1);

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;
use Com\Daw2\Models\ConsultasModel;

class ConsultasController extends BaseController
{
    public function getAll()
    {
        $model = new ConsultasModel();
        $trabajadores = $model->getAll();
    }
}
