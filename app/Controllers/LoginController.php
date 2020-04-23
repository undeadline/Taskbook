<?php

namespace App\Controllers;

use App\Models\User;
use Zombie\Request;
use Zombie\View;

class LoginController
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        return new View(200, 'login');
    }

    public function login()
    {
        $validation = $this->request->validate([
                'login' => 'required|min:1',
                'password' => 'required|min:1'
            ], $this->request->all()
        );

        if (!$validation->valid())
            return response()->redirectWithErrors('/login', $validation->errors());

        $auth = User::auth($this->request->get('login'), $this->request->get('password'));

        if ($auth)
            return response()->redirect('/');

        return response()->redirect('/login');
    }

    public function logout()
    {
        session()->delete('user');

        return response()->redirect('/');
    }
}