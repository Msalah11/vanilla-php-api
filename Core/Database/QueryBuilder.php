<?php

namespace App\Core\Database;

use PDO;

class QueryBuilder
{
    /**
     * The PDO instance.
     *
     * @var PDO
     */
    protected PDO $pdo;

    /**
     * Create a new QueryBuilder instance.
     *
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Select all records from a database table.
     *
     * @param string $table
     * @param string[] $columns
     * @return array|false
     */
    public function selectAll(string $table, array $columns = ['*'], $mode = 'CLASS')
    {
        $columns = implode(',', $columns);
        $mode = $mode == 'CLASS' ? PDO::FETCH_CLASS : PDO::FETCH_COLUMN;

        $statement = $this->pdo->prepare("select {$columns} from {$table}");
        $statement->execute();

        return $statement->fetchAll($mode);
    }

    /**
     * Execute an SQL statement.
     *
     * @param string $query
     * @return false|int
     */
    public function execute(string $query)
    {
        return $this->pdo->exec($query);
    }
}