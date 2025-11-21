<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class AuxRolModel extends BaseDbModel
{
    public function getAll(): array
    {
        $sql = 'SELECT * FROM aux_rol_trabajador ORDER BY nombre_rol DESC';
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function find(int $id)
    {
        $sql = 'SELECT nombre_rol FROM aux_rol_trabajador WHERE id_rol like :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll();
    }
}
