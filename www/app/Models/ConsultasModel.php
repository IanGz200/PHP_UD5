<?php

declare(strict_types=1);

namespace Com\Daw2\Models;

use Com\Daw2\Controllers\PreparedStatemetsController;
use Com\Daw2\Core\BaseDbModel;

class ConsultasModel extends BaseDbModel
{
    private const ORDER_BY = ['username', 'nombre_rol', 'salarioBruto', 'retencionIRPF', 'country_name'];
    private const DEFAULT_ORDER = 1;
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
    public function getFilteredUsers($filters): array
    {
        $sql = self::SELECT_FROM;
        $arrayWhere = $this->getWhere($filters);
        $condiciones = $arrayWhere['condiciones'];
        $valores = $arrayWhere['valores'];
        $orderInt = $this->getOrderInt($filters);
        $page = $this->getPage($filters);
        $offset = ($page - 1) * self::ELEMENTS_PER_PAGE;

        $orderField = self::ORDER_BY[abs($orderInt) - 1] . ($orderInt < 0 ? ' DESC' : '');

        if ($condiciones === []) {
            $sql .= " ORDER BY $orderField LIMIT $offset, " . self::ELEMENTS_PER_PAGE;
            $stmt = $this->pdo->query($sql);
        } else {
            $sql .= " WHERE " . implode(' AND ', $condiciones) .
                " ORDER BY $orderField LIMIT $offset, " . self::ELEMENTS_PER_PAGE;
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($valores);
        }
        return $stmt->fetchAll();
    }

    public function countByFilters(array $filters): int
    {
        $sql = self::SELECT_COUNT;
        $arrayWhere = $this->getWhere($filters);
        $condiciones = $arrayWhere['condiciones'];
        $valores = $arrayWhere['valores'];
        if ($condiciones !== []) {
            $sql .= " WHERE " . implode(' AND ', $condiciones);
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($valores);
        return (int)$stmt->fetchColumn();
    }

    public function getWhere(array $filters): array
    {
        $condiciones =  [];
        $valores = [];
        if (!empty($filters['username'])) {
            $condiciones[] = 't.username like :username';
            $valores['username'] = '%' . $filters['username'] . '%';
        }
        if (!empty($filters['rol'])) {
            $condiciones[] = 'art.nombre_rol like :rol';
            $valores['rol'] = '%' . $filters['rol'] . '%';
        }
        if (!empty($filters['min_salario'])) {
            $condiciones[]  = 't.salarioBruto >= :min_salario';
            $valores['min_salario'] = $filters['min_salario'];
        }
        if (!empty($filters['max_salario'])) {
            $condiciones[] = 't.salarioBruto <= :max_salario';
            $valores['max_salario'] = $filters['max_salario'];
        }
        if (!empty($filters['min_retencion'])) {
            $condiciones[] = 't.retencionIRPF >= :min_retencion';
            $valores['min_retencion'] = $filters['min_retencion'];
        }
        if (!empty($filters['max_retencion'])) {
            $condiciones[] = 't.retencionIRPF <= :max_retencion';
            $valores['max_retencion'] = $filters['max_retencion'];
        }
        if (!empty($filters['paises'])) {
            $i = 1;
            foreach ($filters['paises'] as $pais) {
                $placeholders[]  = ":pais$i";
                $valores["pais$i"] = $pais;
                $i++;
            }
            $condiciones[] = "ac.country_name IN (" . implode(', ', $placeholders) . ")";
        }

        return [
            'condiciones' => $condiciones,
            'valores' => $valores
        ];
    }

    public function getOrderInt(array $filters): int
    {
        if (
            empty($filters['order']) || filter_var($filters['order'], FILTER_VALIDATE_INT) === false
        ) {
            return self::DEFAULT_ORDER;
        } else {
            if (abs((int)$filters['order']) < 1 || abs((int)$filters['order']) > count(self::ORDER_BY)) {
                return self::DEFAULT_ORDER;
            } else {
                return (int)$filters['order'];
            }
        }
    }

    public function getPage(array $filters): int
    {
        if (
            empty($filters['page']) ||
            filter_var(
                $filters['page'],
                FILTER_VALIDATE_INT
            ) === false || (int)$_GET['page'] < 1
        ) {
            return 1;
        } else {
            return (int)$_GET['page'];
        }
    }

    public function getNumPages(array $filter): int
    {
        return (int)ceil($this->countByFilters($filter) / self::ELEMENTS_PER_PAGE);
    }

    public function checkErrors(array $data, ?string $username = null): array
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

    public function edit(array $data, string $username): bool
    {
        $sql = 'update trabajadores 
                set salarioBruto = :salarioBruto, retencionIRPF = :retencionIRPF, 
                    activo = :activo, id_rol = :id_rol, id_country = :id_country, username = :username 
                where username = :usernameOriginal';
        $data['usernameOriginal'] = $username;
        $data['salarioBruto'] = str_replace(',', '.', $data['salario_bruto']);
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
    }

    public function delete(string $username): bool
    {
        $sql = 'delete from trabajadores where username = :username';
        $stmt = $this->pdo->prepare($sql);
        if ($stmt->execute(['username' => $username])) {
            return $stmt->rowCount() === 1;
        } else {
            return false;
        }
    }

    public function find(string $username): array|false
    {
        $sql = 'SELECT * FROM trabajadores WHERE username = :username';
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['username' => $username]);
        return $statement->fetch();
    }
}
