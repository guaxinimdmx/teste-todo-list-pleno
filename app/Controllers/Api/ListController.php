<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\ListModel;
use App\Models\TaskModel;
use App\Services\ApiResponse;

class ListController extends BaseController
{
    public function showAll()
    {
        $userId = $this->request->user_id ?? null;

        $model = new ListModel();

        $lists = $model->where('user_id', $userId)->findAll();

        return ApiResponse::send($lists, 200, 'Listas carregadas com sucesso');
    }

    public function create()
    {
        $data = $this->request->getJSON(true);

        $title = $data['title'] ?? null;
        $userId = $this->request->user_id ?? null;

        if (!$title)
            return ApiResponse::send(null, 400, 'O título da lista é obrigatório');

        $model = new ListModel();

        $id = $model->insert([
            'title' => $title,
            'user_id' => $userId,
        ]);

        if (!$id)
            return ApiResponse::send(null, 500,  'Erro ao criar lista');

        $list = $model->find($id);

        return ApiResponse::send($list, 201, 'Lista criada com sucesso');
    }

    public function show($listId)
    {
        $list = $this->getRecordList($listId);

        if (!$list)
            return ApiResponse::send(null, 404, 'Lista não encontrada');

        $taskModel = new TaskModel();

        $tasks = $taskModel->where('list_id', $list['id'])->findAll();

        $list['tasks'] = $tasks;

        return ApiResponse::send($list, 200, 'Lista carregada com sucesso');
    }

    public function update($listId)
    {
        $data = $this->request->getJSON(true);
        $list = $this->getRecordList($listId);

        if (!$list)
            return ApiResponse::send(null, 404, 'Lista não encontrada');

        $title = $data['title'] ?? null;

        if (!$title)
            return ApiResponse::send(null, 400, 'O título da lista é obrigatório');

        $model = new ListModel();

        $model->update($listId, ['title' => $title]);

        $list['title'] = $title;

        return ApiResponse::send($list, 200, 'Lista atualizada com sucesso');
    }

    public function delete($listId)
    {
        $list = $this->getRecordList($listId);

        if (!$list)
            return ApiResponse::send(null, 404, 'Lista não encontrada');

        $model = new ListModel();
        $model->delete($listId);

        return ApiResponse::send(null, 200, 'Lista removida com sucesso');
    }

    protected function getRecordList($listId)
    {
        $model = new ListModel();
        $useId = $this->request->user_id ?? null;

        return $model->where('id', $listId)
            ->where('user_id', $useId)
            ->first();
    }
}
