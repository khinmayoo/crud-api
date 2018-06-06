<?php

namespace App\Http\Controllers;

use App\CRUD\Task\Service\TaskService;
use Illuminate\Http\Request;
use EllipseSynergie\ApiResponse\Contracts\Response;
use App\Task;
use App\Transformer\TaskTransformer;

class TaskController extends Controller
{
    protected $response;
    protected $taskService;

    /**
     * TaskController constructor.
     *
     * @param Response $response
     *
     * @param TaskService $taskService
     */

    public function __construct(Response $response, TaskService $taskService)
    {
        $this->response = $response;

        $this->taskService = $taskService;
    }

    public function index(Request $request)
    {
        //Get tasks
        $data = $this->taskService->getTasks(array_filter($request->all()));

        // Return a collection of $task with pagination
        return $this->response->withPaginator($data, new  TaskTransformer());
    }

    public function show($id)
    {
        //Get the task
        $task = Task::find($id);
        if (!$task) {
            return $this->response->errorNotFound('Task Not Found');
        }
        // Return a single task
        return $this->response->withItem($task, new  TaskTransformer());
    }

    public function destroy($id)
    {
        //Get the task
        $task = Task::find($id);
        if (!$task) {
            return $this->response->errorNotFound('Task Not Found');
        }

        if ($task->delete()) {
            return $this->response->withItem($task, new  TaskTransformer());
        } else {
            return $this->response->errorInternalError('Could not delete a task');
        }
    }

    public function store(Request $request)
    {
        if ($request->isMethod('put')) {
            //Get the task
            $task = Task::find($request->task_id);
            if (!$task) {
                return $this->response->errorNotFound('Task Not Found');
            }
        } else {
            $task = new Task;
        }

        $task->id = $request['task_id'];
        $task->name = $request['name'];
        $task->description = $request['description'];
        $task->user_id = $request['user_id'];

        if ($task->save()) {
            return $this->response->withItem($task, new  TaskTransformer());
        } else {
            return $this->response->errorInternalError('Could not updated/created a task');
        }
    }
}
