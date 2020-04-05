<?php

namespace App\Controllers;

use App\Models\Task;
use App\Services\TaskService;
use Core\Auth;
use Core\EntityManager;
use Core\View;

class TaskController
{
    /**
     * @var int
     */
    protected $pageSize = 3;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var TaskService
     */
    protected $taskService;

    public function __construct()
    {
        $this->entityManager = EntityManager::get();
        $this->taskService = new TaskService($this->entityManager);
    }

    public function index()
    {
        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : [];

        View::render('index', $this->taskService->getList($sort, (int)$currentPage, $this->pageSize));
    }

    public function create()
    {
        if (!empty($_POST)) {
            if ($this->taskService->crud(new Task(), $_POST)) {
                $_SESSION['alert'] = ['type' => 'success', 'message' => 'Task successfully created!'];
            } else {
                $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Failed to create Task!'];
            }

            header("Location: /");
            die;
        }

        View::render('create');
    }

    public function edit($id)
    {
        if (!Auth::isAuth()) {
            $_SESSION['alert'] = ['type' => 'danger', 'message' => '403. Access forbidden!'];
            header("Location: /");
            die;
        }

        $repository = $this->entityManager->getRepository(Task::class);
        /** @var Task $task */
        $task = $repository->find($id);
        if (null == $task) {
            $_SESSION['alert'] = ['type' => 'danger', 'message' => '404. Page not found!'];
            header("Location: /");
            die;
        }

        if (!empty($_POST)) {
            if ($this->taskService->crud($task, $_POST)) {
                $_SESSION['alert'] = ['type' => 'success', 'message' => 'Task successfully created!'];
            } else {
                $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Failed to update Task!'];
            }

            header("Location: /");
            die;
        }

        $data = [
            'user_name' => $task->getUserName(),
            'email' => $task->getEmail(),
            'description' => $task->getDescription(),
            'is_done' => $task->isIsDone()
        ];

        View::render('edit', $data);
    }
}
