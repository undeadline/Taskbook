<?php

namespace App\Models;

use Zombie\Database\Model;

class User extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected static $table = 'users';

    /**
     * Fields is which available for db query
     *
     * @var array
     */
    protected $fields = ['login', 'password', 'username'];

    /**
     * Authenticate user
     *
     * @param $login
     * @param $password
     * @return bool
     */
    public static function auth($login, $password)
    {
        $user = static::query(
            ['id', 'login', 'password', 'username'],
            'where login = ?',
            [$login])
            ->first();

        if ($user && static::verify($password, $user->password)) {
            session()->set('user', $user->id);
            return true;
        }

        session()->set('errors', ['auth' => ['login or password is wrong']]);

        return false;
    }

    /**
     * Register user
     *
     * @param $params
     */
    public static function register($params)
    {
        $id = static::create(array_merge($params, ['password' => static::hash($params['password'])]));

        if ($id)
            session()->set('user', $id);
    }

    /**
     * Check what user is authenticated
     *
     * @return bool
     */
    public static function isAuth()
    {
        return session()->get('user') ? true : false;
    }

    /**
     * Method for password hashing
     *
     * @param $password
     * @return false|string
     */
    private static function hash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Compare password from request with db password
     *
     * @param $password
     * @param $hash
     * @return bool
     */
    private static function verify($password, $hash)
    {
        return password_verify($password, $hash);
    }
}