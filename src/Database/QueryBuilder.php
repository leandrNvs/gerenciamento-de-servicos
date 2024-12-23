<?php

namespace Src\Database;

use function Src\Helpers\tableName;

class QueryBuilder
{
    private string $tableName;

    private string $query;
    
    private array $whereData = [];

    public function __construct(private Database $db) {}

    public function table(string $tableName)
    {
        $tableInfo = tableName($tableName);

        $this->tableName = $tableInfo['tableName'];

        return $this;
    }

    public function select($fields = '*')
    {
        $this->query = "select {$fields} from {$this->tableName}";

        return $this;
    }

    public function delete()
    {
        $this->query = "delete from {$this->tableName}";

        return $this;
    }

    public function update()
    {
        $this->query = "update {$this->tableName} set {{columns}}";

        return $this;
    }    

    public function insert()
    {
        $this->query = "insert into {$this->tableName} ({{columns}}) values ({{values}})";

        return $this;
    }

    public function count(string $field, $as = null)
    {
        $this->query = "select count({$field}) as " . ($as? $as : 'total') . " from {$this->tableName}";

        return $this;
    }

    public function limit(int $limit)
    {
        $this->query .= " limit {$limit}";

        return $this;
    }

    public function skip(int $offset)
    {
        $this->query .= " offset {$offset}";

        return $this;
    }

    public function where(...$arguments)
    {
        $this->whereData[$arguments[0]] = count($arguments) === 2? $arguments[1] : $arguments[2];

        $this->query .= " where {$arguments[0]} " . (count($arguments) === 2? "=" : $arguments[1]) . " :{$arguments[0]}";

        return $this;
    }

    public function execute(array $data = [])
    {
        $data = array_merge($data, $this->whereData);

        $this->completeQuery($data, $operation);

        $conn = $this->db->getConnection();

        $stmt = $conn->prepare($this->query);
        $stmt->execute($data);

        return $operation === 'insert'
            ? $conn->lastInsertId()
            : ['data' => $stmt->fetchAll(), 'rows' => $stmt->rowCount()];
    }

    private function completeQuery(array $data, &$operation)
    {
        preg_match('/^[\w]+/', $this->query, $match);

        $keys = array_keys($data);

        $operation = $match[0];

        switch($match[0]) {
            case 'insert':
                    $bindings = array_map(fn($i) => ':' . $i, $keys);

                    $this->query = str_replace(
                        ["{{columns}}", '{{values}}'],
                        [implode(', ', $keys), implode(', ', $bindings)],
                        $this->query
                    );
                break;
            case 'update':
                    $bindings = array_map(fn($i) => $i . ' = :' . $i, $keys);

                    $this->query = str_replace("{{columns}}", implode(', ', $bindings), $this->query);
                break;
        }
    }
}
