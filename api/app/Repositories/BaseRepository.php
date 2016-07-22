<?php namespace App\Repositories;

abstract class BaseRepository
{
    protected $repository;

    public function find($id)
    {
        return $this->repository->findOrFail($id);
    }

    public function findBy(array $filters)
    {
        return $this->repository->findBy($filters);
    }

    public function all()
    {
        return $this->repository->all();
    }
}