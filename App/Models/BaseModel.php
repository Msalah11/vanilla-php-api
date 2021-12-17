<?php

namespace App\App\Models;

use App\Core\Application;
use App\Core\Database\QueryBuilder;
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
}