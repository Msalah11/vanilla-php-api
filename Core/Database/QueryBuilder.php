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
     * @param string $mode
     * @return array|false
     */
    public function selectAll(string $table, array $columns = ['*'], string $mode = 'CLASS')
    {
        $columns = implode(',', $columns);
        $mode = $mode == 'CLASS' ? PDO::FETCH_CLASS : PDO::FETCH_COLUMN;

        $statement = $this->pdo->prepare("select {$columns} from {$table}");
        $statement->execute();

        return $statement->fetchAll($mode);
    }

    /**
     * Find One Record.
     *
     * @param string $table
     * @param string[] $columns
     * @param array $conditions
     * @return array|false
     */
    public function find(string $table, array $columns = ['*'], array $conditions = [])
    {
        $columns = implode(',', $columns);
        $query = "select {$columns} from {$table}";

        if(!empty($conditions)) {
            $query .= $this->processConditions($conditions);
        }

        $statement = $this->pdo->prepare($query);
        $statement->execute();

        return $statement->fetchObject();
    }

    /**
     * Update Record.
     *
     * @param string $table
     * @param array $conditions
     * @param array $data
     * @return bool|false
     */
    public function update(string $table, array $conditions , array $data): bool
    {

        $query = "UPDATE {$table}";

        if(!empty($data)) {
            $query .= $this->processData($data);
        }

        if(!empty($conditions)) {
            $query .= $this->processConditions($conditions);
        }

        $statement = $this->pdo->prepare($query);

        return $statement->execute();
    }

    public function create(string $table, array $data)
    {
        $keys = implode(', ', array_keys($data));
        $query = "INSERT INTO {$table} ({$keys})";
        $query .= $this->processInsertedData($data);

        $statement = $this->pdo->prepare($query);
        $statement->execute();

        return $this->find($table, ['*'], ['id' => $this->pdo->lastInsertId()]);
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

    private function processConditions($conditions): string
    {
        $attributes = array_keys($conditions);

        $sql = implode(" AND ", array_map(fn($attr) => "$attr = '{$conditions[$attr]}'", $attributes));

        return " WHERE {$sql}";
    }

    private function processData($data): string
    {
        $attributes = array_keys($data);

        $sql = implode(", ", array_map(fn($attr) => "$attr = '{$data[$attr]}'", $attributes));

        return " SET {$sql}";
    }

    private function processInsertedData($data): string
    {
        $attributes = array_keys($data);

        $sql = implode(", ", array_map(fn($attr) => "'{$data[$attr]}'", $attributes));

        return " VALUES({$sql})";
    }
}