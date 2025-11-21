<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class AuxCountryModel extends BaseDbModel
{
    public function getAll(): array
    {
        $sql = 'SELECT country_name,id FROM aux_countries order by country_name';
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }
    public function find(int $id): array
    {
        $sql = 'SELECT country_name FROM aux_countries where id like :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll();
    }
}
