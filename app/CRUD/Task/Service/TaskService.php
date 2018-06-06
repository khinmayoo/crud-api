<?php
namespace App\CRUD\Task\Service;

use App\Task;

class TaskService
{
    /**
     * This function is to get the task data by filter paramter
     *
     * @param $inputs
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getTasks($inputs)
    {
        $query = Task::query();

        if (isset($inputs['user_id'])) {
            $query->whereUserId($inputs['user_id']);
        }

        if (isset($inputs['name'])) {
            $query->whereName($inputs['name']);
        }

        return $query->paginate(15);
    }
}
