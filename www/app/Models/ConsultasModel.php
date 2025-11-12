<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;

class ConsultasModel extends BaseDbModel
{
    private const SELECT_FROM = "select t.username,art.nombre_rol,t.salarioBruto,t.retencionIRPF,ac.country_name
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
        $evaluaciones = [];
        $variables = [];

        if (!empty($filtered['username'])) {
            $evaluaciones[] = " t.username like :username";
            $variables['username'] = "%" . $filtered['username'] . "%";
        }
        if (!empty($filtered['rol'])) {
            $evaluaciones[] = " art.nombre_rol like :rol ";
            $variables['rol'] = $filtered['rol'];
        }
        if (!empty($filtered['min_salario']) || !empty($filtered['max_salario'])) {
            $condicion = [];
            if (!empty($filtered['min_salario'])) {
                $condicion[] = " t.salarioBruto >= :min_salario ";
                $variables['min_salario'] = intval($filtered['min_salario']);
            }
            if (!empty($filtered['max_salario'])) {
                $condicion[] = " t.salarioBruto <= :max_salario ";
                $variables['max_salario'] = intval($filtered['max_salario']);
            }
            $evaluaciones[] = implode(' and ', $condicion);
        }
        if (!empty($filtered['paises'])) {
            $i = 1;
            foreach ($filtered['paises'] as $pais) {
                $placeholders[] = ":pais$i";
                $variables["pais$i"] = $pais;
                $i++;
            }
            $evaluaciones[] = " ac.country_name IN (" . implode(' , ', $placeholders) . ")";
        }
        if (!empty($filtered['retencion'])) {
            $evaluaciones[] = "t.retencionIRPF like :retencion";
            $number = number_format(floatval($filtered['retencion']), 2, '.', ' ');
            $variables['retencion'] = $number;
        }

        if (!empty($filtered)) {
            if (!empty($variables)) {
                $sql .= " where" . implode(' and ', $evaluaciones);
            }
            if (!empty($filtered['order'])) {
                switch ($filtered['order']) {
                    case '1':
                        $sql .= " ORDER BY t.username ASC";
                        break;
                    case '2':
                        $sql .= " ORDER BY art.nombre_rol ASC";
                        break;
                    case '3':
                        $sql .= " ORDER BY t.salarioBruto ASC";
                        break;
                    case '4':
                        $sql .= " ORDER BY t.retencionIRPF ASC";
                        break;
                    case '5':
                        $sql .= " ORDER BY ac.country_name ASC";
                        break;
                }
            }
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($variables);
        } else {
            $stmt = $this->pdo->query($sql);
        }
        return $stmt->fetchAll();
    }
}
