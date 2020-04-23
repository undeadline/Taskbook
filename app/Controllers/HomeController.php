<?php

namespace App\Controllers;

use App\Models\Task;
use Zombie\Request;
use Zombie\View;

class HomeController
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index()
    {
        list($field, $direction) = [$this->request->query('f'),$this->request->query('s')];

        if (Task::is_sortable($field) && Task::direction($direction))
            $sort = "order by $field $direction";

        list($tasks, $links) = Task::query(
            ['id', 'name', 'email', 'text', 'status', 'edited'],
            $sort ?: '')
            ->paginate(3, $this->request->query('page'));

        return new View(200, 'home', ['tasks' => $tasks, 'links' => $links]);
    }
}