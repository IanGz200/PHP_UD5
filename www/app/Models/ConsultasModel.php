<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class ConsultasModel extends BaseDbModel
{
    private const SELECT_FROM = "select t.username,art.nombre_rol,t.salarioBruto,t.retencionIRPF 
            from trabajadores t
            left join ud5.aux_rol_trabajador art on t.id_rol = art.id_rol
            left join aux_countries ac on t.id_country = ac.id";
    public function getAll(): array
    {
        $sql = "select t.username,t.salarioBruto,t.retencionIRPF,t.activo,art.nombre_rol,ac.country_name 
        from trabajadores t
        left join ud5.aux_rol_trabajador art on t.id_rol = art.id_rol
        left join aux_countries ac on t.id_country = ac.id";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function getAllBySalary(): array
    {
        $sql = "select t.username,t.salarioBruto,t.retencionIRPF,t.activo,art.nombre_rol,ac.country_name 
        from trabajadores t
        left join ud5.aux_rol_trabajador art on t.id_rol = art.id_rol
        left join aux_countries ac on t.id_country = ac.id
        order by salarioBruto desc";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function getStandard(): array
    {
        $sql = "select t.username,t.salarioBruto,t.retencionIRPF,t.activo,art.nombre_rol,ac.country_name 
        from trabajadores t
        left join ud5.aux_rol_trabajador art on t.id_rol = art.id_rol
        left join aux_countries ac on t.id_country = ac.id
        where art.nombre_rol like 'standard'";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function getCarlos(): array
    {
        $sql = "select t.username,t.salarioBruto,t.retencionIRPF,t.activo,art.nombre_rol,ac.country_name 
        from trabajadores t
        left join ud5.aux_rol_trabajador art on t.id_rol = art.id_rol
        left join aux_countries ac on t.id_country = ac.id
        where t.username like 'Carlos%'";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Ejercicios de prepared statements
     */
    public function getFilteredUsers($filtered): array
    {
        $sql = self::SELECT_FROM;

        if (!empty($filtered['username'])) {
            $sql .= " where t.username like :username";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['username' => '%' . $filtered['username'] . '%']);
        } elseif (!empty($filtered['rol'])) {
            $sql .= " where art.nombre_rol like :rol";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['rol' => '%' . $filtered['rol'] . '%']);
        } else {
            $stmt = $this->pdo->query($sql);
        }
        return $stmt->fetchAll();
    }
}
