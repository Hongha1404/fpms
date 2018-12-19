<?php

namespace App\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    public function count();
    public function store(array $attributes);
    public function update($id, array $attributes);
    public function all($columns = ['*'], string $orderBy = 'id', string $sortBy = 'asc');
    public function find($id);
    public function save($model, $input);
    public function delete($id);
    public function page($number, string $orderBy = 'created_at', string $sortBy = 'desc');
}
