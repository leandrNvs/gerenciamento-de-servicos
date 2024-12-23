<?php

namespace Src\Database;

use Closure;

use function Src\Helpers\tablename;

class Schemas
{
    public function __construct(
        private Database $db,
        private SchemasDefinition $schema
    ) {}

    public function create(string $tableName, Closure $definition)
    {
        $tableInfo = tablename($tableName);

        $table = "CREATE TABLE IF NOT EXISTS {$tableInfo['tableName']} ({{columns}})";

        $this->schema->setPrimaryKey($tableInfo['primaryKey']);

        $definition($this->schema);

        $this->db->getConnection()->query(
            str_replace('{{columns}}', $this->schema->get(), $table)
        );
    }
}
