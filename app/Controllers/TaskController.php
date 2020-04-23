<?php

namespace App\Controllers;

use App\Models\Task;
use Zombie\Request;
use Zombie\View;

class TaskController
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function create()
    {
        $validation = $this->request->validate(
            [
                'name' => 'required|min:2|max:255',
                'email' => 'required|email|min:5|max:255',
                'text' => 'required|min:1|max:65535'
            ], $this->request->all()
        );

        if (!$validation->valid())
            return response()->redirectWithErrors('/', $validation->errors());

        Task::create($this->request->all());

        session()->set('success', 'Task was created');

        return response()->redirect('/');
    }

    public function show($id)
    {
        if (!auth())
            return response()->redirect('/login');

        if (!is_numeric($id))
            return abort_404();

        $task = Task::query(['id', 'name', 'email', 'text', 'status'], 'where id = ?', [$id])->first();

        if ($task)
            return new View(200, 'tasks/task-update', ['task' => $task]);

        return response()->redirect('/');
    }

    public function update($id)
    {
        if (!auth())
            return response()->redirect('/login');

        if (!is_numeric($id))
            return abort_404();

        $validation = $this->request->validate(
            [
                'text' => 'required|min:1|max:65535',
                'status' => 'required|in:New,Done'
            ], $this->request->all()
        );

        if (!$validation->valid())
            return response()->redirectWithErrors('/', $validation->errors());

        $task = Task::query(['text'], 'where id = ?', [$id])->first();

        if ($task) {
            $data = [
                'text' => $this->request->get('text'),
                'status' => $this->request->get('status')
            ];

            if (htmlspecialchars_decode($task->text) !== $this->request->get('text'))
                $data['edited'] = 1;

            Task::update('where id = :id', ['id' => $id], $data);

            return response()->redirect('/');
        }

        return abort_404();
    }
}