<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class ConsultasModel extends BaseDbModel
{
    public function getAll(): array
    {
        $sql = "SELECT * FROM trabajadores";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->fetchAll();
    }

    public function getAllBySalary(): array
    {
        $sql = "SELECT * FROM trabajadores order by salarioBruto desc";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->fetchAll();
    }

    public function getStandard(): array
    {
        $sql = "SELECT * FROM trabajadores t left join aux_rol_trabajadores c on t.id_rol = c.id_rol";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->fetchAll();
    }

    public function getCarlos(): array
    {
        $sql = "SELECT * FROM trabajadores where username like 'Carlos%'";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->fetchAll();
    }
}
