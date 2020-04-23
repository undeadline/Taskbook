<?php

namespace App\Controllers;

use App\Models\User;
use Zombie\Request;
use Zombie\View;

class RegisterController
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        return new View(200, 'register');
    }

    public function register()
    {
        User::register($this->request->all());

        return response()->redirect('/');
    }
}