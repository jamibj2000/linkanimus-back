<?php

namespace App\Controllers\Login;
use App\Controllers\CorsController;
// use App\Controllers\DataManager\CorsController;

class LoginController extends CorsController
{
    public function login()
    {
        $this->request->isAJAX();
        $this->response->setStatusCode(200);

        $responseData = [];

        if ($response->getStatus(200)) {
            $responseData = $this->getUserData();
        } else {
            $this->removeLoginKey();
        }

        return $this->response->setJSON(['message' => 'Hello, World!']);
    }

    public function removeLoginKey()
    {
        return $this->response->setJSON(['message' => 'Hello, World!']);
    }

    /**
     * Obtiene la data que el usuario consulta al momento de cargar su perfil.
     * Es decir cuando requiere por acceso a la informacion del usuario o por acceso
     * a la plataforma.
     * 
     * @return Object
     */
    public function getUserData()
    {
        $db = \Config\Database::connect();

        $builder = $db->table('user');
        $builder->select('*');
        $builder->where('userId', 1);
        $query = $builder->get();

        return $this->response->setJSON($query->getResult());
    }
}