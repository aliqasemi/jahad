<?php

namespace App\Infrastructure\InterfaceRepository;

interface ProjectInterface
{
    public function index($data);

    public function indexUser(array $data, int $user_id);

    public function store(array $data);

    public function show(int $projectId);

    public function showUser(int $projectId);

    public function update(array $data, int $projectId);

    public function changeStep(array $data, int $projectId);

    public function delete(int $projectId);
}
