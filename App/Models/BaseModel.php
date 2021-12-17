<?php

namespace App\Models;

use App\Core\Application;
use Exception;

abstract class BaseModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected string $table;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected string $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected array $attributes = [];

    /**
     * The attributes that are mass assignable.
     */
    private $builder;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->builder = Application::get('database');
    }

    /**
     * Select all records from a database table.
     */
    public function all()
    {
        return $this->builder->selectAll($this->table);
    }

    /**
     * Select One record from a database table with conditions.
     */
    public function find(array $conditions = [], array $columns = ['*'])
    {
        return $this->builder->find($this->table, $columns, $conditions);
    }

    /**
     * Update One record from a database table.
     */
    public function update(array $conditions, array $data)
    {
        return $this->builder->update($this->table, $conditions, $data);
    }

    /**
     * Update One record from a database table.
     */
    public function create(array $data)
    {
        $data = $this->filterData($data);

        return $this->builder->create($this->table, $data);
    }

    private function filterData($items)
    {
        foreach ($items as $key => $item) {

            if (array_search($key, $this->attributes) === false) {
                unset($items[$key]);
            }
        }

        return $items;
    }
}