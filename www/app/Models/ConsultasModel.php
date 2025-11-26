<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Controllers\PreparedStatemetsController;
use Com\Daw2\Core\BaseDbModel;

class ConsultasModel extends BaseDbModel
{
    private const ORDER_BY = ['username', 'nombre_rol', 'salarioBruto', 'retencionIRPF', 'country_name'];
    private const DEFAUL_ORDER = 1;
    private const ELEMENTS_PER_PAGE = 25;
    private const QUERY_FROM = 'from trabajadores t
            left join ud5.aux_rol_trabajador art on t.id_rol = art.id_rol
            left join aux_countries ac on t.id_country = ac.id';
    private const SELECT_FROM = 'select t.username,art.nombre_rol,t.salarioBruto,t.retencionIRPF,ac.country_name 
            ' . self::QUERY_FROM;
    private const SELECT_COUNT = 'select count(*) as total ' . self::QUERY_FROM;

    public function getAll(): array
    {
        $sql = self::SELECT_FROM;
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
        if (!empty($filtered['min_retencion']) || !empty($filtered['max_retencion'])) {
            $condicion = [];
            if (!empty($filtered['min_retencion'])) {
                $condicion[] = " t.retencionIRPF >= :min_retencion ";
                $variables['min_retencion'] = intval($filtered['min_retencion']);
            }
            if (!empty($filtered['max_retencion'])) {
                $condicion[] = " t.retencionIRPF <= :max_retencion ";
                $variables['max_retencion'] = intval($filtered['max_retencion']);
            }
            $evaluaciones[] = implode(' and ', $condicion);
        }
        if (!empty($filtered)) {
            if (!empty($variables)) {
                $sql .= " where" . implode(' and ', $evaluaciones);
            }
            if (!empty($this->getOrderInt($filtered))) {
                switch ($this->getOrderInt($filtered)) {
                    case 1:
                        $sql .= " ORDER BY t.username ASC";
                        break;
                    case -1:
                        $sql .= " ORDER BY t.username DESC";
                        break;
                    case 2:
                        $sql .= " ORDER BY art.nombre_rol ASC";
                        break;
                    case -2:
                        $sql .= " ORDER BY art.nombre_rol DESC";
                        break;
                    case 3:
                        $sql .= " ORDER BY t.salarioBruto ASC";
                        break;
                    case -3:
                        $sql .= " ORDER BY t.salarioBruto DESC";
                        break;
                    case 4:
                        $sql .= " ORDER BY t.retencionIRPF ASC";
                        break;
                    case -4:
                        $sql .= " ORDER BY t.retencionIRPF DESC";
                        break;
                    case 5:
                        $sql .= " ORDER BY ac.country_name ASC";
                        break;
                    case -5:
                        $sql .= " ORDER BY ac.country_name DESC";
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

    public function getOrderInt(array $filters): int
    {
        if (
            empty($filters['order']) || filter_var($filters['order'], FILTER_VALIDATE_INT) === false ||
            abs((int)$filters['order']) < 1 || $filters['order'] > count(self::ORDER_BY)
        ) {
            return 1;
        } else {
            return (int)$filters['order'];
        }
    }

    public function checkErrors(array $data, ?string $username): array
    {
        $errors = [];
        if (empty($data['username'])) {
            $errors['username'] = 'El nombre es obligatorio';
        } elseif (!preg_match('/^\w{4,50}$/iu', $data['username'])) {
            $errors['username'] =
                'El nombre debe estar formado por letras, números o _ y estar formado por entre 4 y 50 caracteres';
        } else {
            if (($username === null) || $username !== $data['username']) {
                if ($this->find($data['username']) !== false) {
                    $errors['username'] = 'El nombre de usuario ya se encuentra en uso';
                }
            }
        }
        if (empty($data['salario_bruto'])) {
            $errors['salario_bruto'] = 'El salario es obligatorio';
        } elseif (!preg_match('/^\d+(,\d{1,2})?$/iu', $data['salario_bruto'])) {
            $errors['salario_bruto'] = 'El salario será un número con máximo dos decimales. Separador de decimales ,';
        } else {
            $salario = str_replace(',', '.', $data['salario_bruto']);
            if ($salario < 500) {
                $errors['salario_bruto'] = 'El salario debe ser de la menos 500€';
            }
        }

        if (empty($data['retencionIRPF'])) {
            $errors['retencionIRPF'] = 'El IRPF es obligatorio';
        } elseif (filter_var($data['retencionIRPF'], FILTER_VALIDATE_INT) === false) {
            $errors['retencionIRPF'] = 'El IRPF debe ser un número entero entre 0 y 100';
        } elseif ($data['retencionIRPF'] < 0 || $data['retencionIRPF'] > 100) {
            $errors['retencionIRPF'] = 'El IRPF debe ser un número entero entre 0 y 100';
        }

        if (empty($data['id_rol'])) {
            $errors['id_rol'] = 'El rol es obligatorio';
        } elseif (filter_var($data['id_rol'], FILTER_VALIDATE_INT) === false) {
            $errors['id_rol'] = 'El rol seleccionado no es válido';
        } else {
            $rolModel = new AuxRolModel();
            if ($rolModel->find((int)$data['id_rol']) === false) {
                $errors['id_rol'] = 'El rol seleccionado no es válido';
            }
        }

        if (empty($data['id_country'])) {
            $errors['id_country'] = 'La nacionalidad es obligatoria';
        } elseif (filter_var($data['id_country'], FILTER_VALIDATE_INT) === false) {
            $errors['id_country'] = 'La nacionalidad seleccionada no es válida';
        } else {
            $countryModel = new AuxCountryModel();
            if ($countryModel->find((int)$data['id_country']) === false) {
                $errors['id_country'] = 'La nacionalidad seleccionada no es válida';
            }
        }

        if (!isset($data['activo'])) {
            $errors['activo'] = 'Seleccione si el trabajador se encuentra activo';
        } elseif (filter_var($data['activo'], FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE) === null) {
            $errors['activo'] = 'Valor seleccionado no válido';
        }

        return $errors;
    }

    public function insert(array $data): bool
    {
        $sql = 'insert into trabajadores (username, salarioBruto, retencionIRPF, activo, id_rol, id_country) 
                values (:username, :salarioBruto, :retencionIRPF, :activo, :id_rol, :id_country)';
        $userData = [
            'username' => $data['username'],
            'salarioBruto' => str_replace(',', '.', $data['salario_bruto']),
            'retencionIRPF' => $data['retencionIRPF'],
            'activo' => $data['activo'],
            'id_rol' => $data['id_rol'],
            'id_country' => $data['id_country']
        ];
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($userData);
    }

    public function find(string $username): array|false
    {
        $sql = 'SELECT * FROM trabajadores WHERE username = :username';
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['username' => $username]);
        return $statement->fetch();
    }
}
