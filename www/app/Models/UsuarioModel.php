<?php

declare(strict_types=1);
namespace Com\Daw2\Models;

use Com\Daw2\Core\BaseDbModel;
use http\Env;
use PDO;

class UsuarioModel extends BaseDbModel
{

    private const USERS = 'SELECT us.*,ar.nombre_rol,ac.country_name FROM usuario us 
                            JOIN aux_rol ar on us.id_rol = ar.id_rol 
                            left join aux_countries ac on us.id_country = ac.id';

    public function getUsuarios()
    {

        $statement = $this->pdo->query(self::USERS);
        return $statement->fetchAll(pdo::FETCH_ASSOC);

    }

    public function getUsuariosOrdenadosMayorAMenorSB()
    {

        $sttmt = $this->pdo->query(self::USERS . " order by salarioBruto DESC");
        return $sttmt->fetchAll(pdo::FETCH_ASSOC);


    }

    public function getUsuariosStandar()
    {

        $sttmt = $this->pdo->query(self::USERS . " WHERE us.id_rol = 5");
        return $sttmt->fetchAll(pdo::FETCH_ASSOC);


    }

    public function getUsuariosCarlos()
    {

        $sttmt = $this->pdo->query(self::USERS. " WHERE username like 'Carlos%'");
        return $sttmt->fetchAll(pdo::FETCH_ASSOC);


    }

}