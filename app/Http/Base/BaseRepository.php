<?php

namespace App\Http\Base;

use Illuminate\Support\Facades\DB;

class BaseRepository {
    protected $repository;

    public function __construct($category) {
        $this->repository = $category;
    }

    public function findAll() {
        return $this->repository->get();
    }

    public function select($query) {
        return $this->repository->select($query);
    }

    public function findById($id) {
        return $this->repository->where('id', $id)->first();
    }

    public function create($attributes) {
        return $this->repository->create($attributes);
    }

    public function insert($attributes) {
        return DB::table($this->repository->getTable())->insert($attributes);
    }

    public function update($id, array $attributes) {
        return $this->repository->where('id', $id)->update($attributes);
    }

    public function delete($id) {
        return $this->repository->where('id', $id)->delete();
    }
}