<?php

namespace Gousto\Repositories;

use Gousto\Contracts\Model;
use Gousto\Contracts\Repository;
use Gousto\Exceptions\RecipeNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class RecipeRepository
 * @package Gousto\Repositories
 */
class RecipeRepository implements Repository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * RecipeRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritdoc
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * @inheritdoc
     */
    public function find($id)
    {
        try {
            return $this->model->find($id);
        } catch (ModelNotFoundException $mnf) {
            throw new RecipeNotFoundException("Recipe $id does not exist.");
        }
    }

    /**
     * @inheritdoc
     */
    public function findBy(array $criteria)
    {
        return $this->model->findBy($criteria);
    }

    /**
     * @inheritdoc
     */
    public function create(array $data)
    {
        $this->model->create($data);
        return $this->model->save();
    }

    /**
     * @inheritdoc
     */
    public function update($id, array $data)
    {
        try {
            $this->model->find($id);
            $this->model->update($data);
            return $this->model->save();
        } catch (ModelNotFoundException $mnf) {
            throw new RecipeNotFoundException("Recipe $id does not exist.");
        }
    }
}
