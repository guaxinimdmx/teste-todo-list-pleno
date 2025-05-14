<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\ListModel;
use App\Models\TaskModel;
use App\Services\ApiResponse;

class TaskController  extends BaseController
{
    public function create($listId)
    {
        $data = $this->request->getJSON(true);
        $list = $this->getRecordList($listId);

        if (!$list)
            return ApiResponse::send(null, 404, 'Lista não encontrada');


        $description = $data['description'] ?? null;

        if (!$description)
            return ApiResponse::send(null, 400, 'Descrição da tarefa é obrigatória');

        $taskModel = new TaskModel();

        $id = $taskModel->insert([
            'list_id'     => $list['id'],
            'description' => $description,
            'is_done'     => false
        ]);

        if (!$id)
            return ApiResponse::send(null, 500, 'Erro ao criar tarefa');

        $task = $taskModel->find($id);

        $task['is_done'] = (bool) $task['is_done'];

        return ApiResponse::send($task, 201, 'Tarefa criada com sucesso');
    }

    public function update($taskId)
    {
        $data = $this->request->getJSON(true);
        $task = $this->getRecordTask($taskId);

        if (!$task)
            return ApiResponse::send(null, 404, 'Tarefa não encontrada ou acesso negado');

        $update = [];

        if (isset($data['description']))
            $update['description'] = $data['description'];

        if (isset($data['is_done']))
            $update['is_done'] = (bool) $data['is_done'];

        if (empty($update))
            return ApiResponse::send(null, 400, 'Nenhum campo para atualizar');

        $model = new TaskModel();
        $model->update($taskId, $update);

        $updated = $model->find($taskId);

        return ApiResponse::send($updated, 200, 'Tarefa atualizada com sucesso');
    }

    public function delete($taskId)
    {
        $task = $this->getRecordTask($taskId);

        if (!$task)
            return ApiResponse::send(null, 404, 'Tarefa não encontrada ou acesso negado');

        $model = new TaskModel();
        $model->delete($taskId);

        return ApiResponse::send(null, 200, 'Tarefa removida com sucesso');
    }

    protected function getRecordList($listId)
    {
        $model = new ListModel();

        $useId = $this->request->user_id ?? null;

        return $model->where('id', $listId)
            ->where('user_id', $useId)
            ->first();
    }

    protected function getRecordTask($taskId)
    {
        $listModel = new ListModel();
        $taskModel = new TaskModel();

        $userId = $this->request->user_id ?? null;

        $task = $taskModel->find($taskId);

        if (!$task) return null;

        $list = $listModel->where('id', $task['list_id'])
            ->where('user_id', $userId)
            ->first();

        if (!$list) return null;

        return $task;
    }
}
