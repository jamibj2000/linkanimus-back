<?php

namespace App\Controllers\Login;

use App\Controllers\CorsController;

class LoginController extends CorsController
{  
    public function login(){
        $db = \Config\Database::connect();
        $userAccount = $this->request->getPost('userAccount');
        $password = $this->request->getPost('password');

        // Recuperar el hash de la base de datos
        $query = $db->table('users')->getWhere(['userAccount' => $userAccount])->getRow();

        if ($query) {
            $hashed_password = $query->password;

            $userData = [
                "userName" => $query->userName,
                "key" => $query->userCurrentKey,
                "points" => $query->userPoints
            ];

            // Verificar la contraseña
            if (password_verify($password, $hashed_password)) {
                // Contraseña verificada
                return $this->response->setJSON([
                    'message' => 'Inicio de sesión exitoso.',
                    'status' => 'success',
                    'requestData' => $userData
                ]);
            } else {
                // Contraseña incorrecta
                return $this->response->setJSON([
                    'message' => 'Contraseña incorrecta.',
                    'status' => 'error'
                ]);
            }
        } else {
            // Usuario no encontrado
            return $this->response->setJSON([
                'message' => 'Usuario no encontrado.',
                'status' => 'error'
            ]);
        }
    }


    /**
     * Guarda un nuevo usuario con la contraseña cifrada.
     *
     * @param array $userData
     * @return bool
     */
    public function saveUser()
    {
        $db = \Config\Database::connect();
        $userAccount = $this->request->getPost('userAccount');
        $userName = $this->request->getPost('userName');
        $password = $this->request->getPost('password');

        $queryAccount = $db->table('users')->getWhere(['userAccount' => $userAccount])->getRow();

        // Verifica si el usuario ya existe
        if (!isset($queryAccount)) {

            $userData =  [
                "userAccount" => $userAccount,
                "userName" => $userName,
                "password" => $password
            ];

            // Cifrar la contraseña antes de guardarla
            if (isset($userData['password']) && strlen($userData['password']) > 5) {
                $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);
            } else {
                return $this->response->setJSON([
                    'message' => 'La contraseña debe tener al menos 6 caracteres.',
                    'status' => 'error'
                ]);
            }

            // Crear el usuario
            if (isset($userData['userAccount']) && strlen($userData['userAccount']) > 6) {
                $db->table('users')->insert($userData);
                if ($db->affectedRows() > 0) {
                    return $this->response->setJSON([
                        'message' => 'Cuenta creada exitosamente.',
                        'status' => 'success'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'message' => 'Error al crear la cuenta.',
                        'status' => 'error'
                    ]);
                }
            } else {
                return $this->response->setJSON([
                    'message' => 'El nombre de usuario debe tener al menos 6 caracteres.',
                    'status' => 'error'
                ]);
            }
        } else {
            return $this->response->setJSON([
                'message' => 'Este correo ya está vinculado a una cuenta.',
                'status' => 'error'
            ]);
        }
    }
}