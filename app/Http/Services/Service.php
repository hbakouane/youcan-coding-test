<?php

namespace App\Http\Services;

class Service
{
    public $model;

    /**
     * Get the required fields of the Product model
     *
     * @return void
     */
    public function getRequiredFields()
    {
        $requiredFields = [];
        foreach($this->model::$rules as $key => $value) {
            if (str_contains($value, 'required')) {
                array_push($requiredFields, $key);
            }
        }
        return $requiredFields;
    }
    
    /**
     * Get all records of a model
     *
     * @param  mixed $orderBy
     * @param  mixed $relations
     * @return void
     */
    public function getAll(array $orderBy = ['id', 'DESC'], array $relations = [])
    {
        // PHP 8.0
        // return $this->model::with($relations)?->orderBy($order)->get();
        if (count($relations) > 0) {
            return $this->model::with($relations)->orderBy($orderBy)->get();
        } else {
            return $this->model::orderBy($orderBy[0] ?? 'id', $orderBy[1] ?? 'DESC')->get();
        }
    }
    
    /**
     * Get all records of a model in a paginated way
     *
     * @param  mixed $itemsToPaginateBy
     * @param  mixed $orderBy
     * @param  mixed $relations
     * @return void
     */
    public function getPaginated($itemsToPaginateBy, array $orderBy = ['id', 'DESC'], array $relations = [])
    {
        if (count($relations) > 0) {
            return $this->model::with($relations)->orderBy($orderBy[0] ?? 'id', $orderBy[1] ?? 'DESC')->paginate($itemsToPaginateBy);
        } else {
            return $this->model::orderBy($orderBy[0] ?? 'id', $orderBy[1] ?? 'DESC')->paginate($itemsToPaginateBy);
        }
    }
    
    /**
     * Get a single record by its ID
     *
     * @param  int $id
     * @return void
     */
    public function getById(int $id)
    {
        return $this->model::find($id);
    }
    
    /**
     * Create a new object of the model
     *
     * @param  mixed $data
     * @return void
     */
    public function create($data = [])
    {
        // Fill/Load the request
        return (new $this->model)->create($data);
    }
    
    /**
     * Deletes a record
     *
     * @param  mixed $id
     * @return void
     */
    public function delete($id)
    {
        // Fill/Load the request
        return $this->getById($id)->delete($id);
    }
}