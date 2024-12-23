<?php

namespace Src\Database;

use function Src\Helpers\tableName;

class SchemasDefinition
{
    private array $tableDefinition = [];

    private array $tableInfo = [];

    public function id(): self
    {
        $this->tableDefinition[] = "{$this->tableInfo['primaryKey']} INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT";

        return $this;
    }

    public function varchar(string $col, $size = 255): self
    {
        $this->tableDefinition[] = "{$col} VARCHAR({$size}) NOT NULL";

        return $this;
    }

    public function year(string $col, $size = 4): self
    {
        $this->tableDefinition[] = "{$col} YEAR($size) NOT NULL";

        return $this;
    }

    public function text(string $col): self
    {
        $this->tableDefinition[] = "{$col} TEXT NOT NULL";

        return $this;
    }

    public function date(string $col): self
    {
        $this->tableDefinition[] = "{$col} DATE NOT NULL";

        return $this;
    }

    public function bool(string $col): self
    {
        $this->tableDefinition[] = "{$col} BOOL NOT NULL";

        return $this;
    }

    public function decimal(string $col, $size = 8, $precision = 2): self
    {
        $this->tableDefinition[] = "{$col} DECIMAL({$size}, {$precision}) NOT NULL";

        return $this;
    }

    public function smallint(string $col): self
    {
        $this->tableDefinition[] = "{$col} SMALLINT NOT NULL";

        return $this;
    }

    public function created_at(string $col): self
    {
        $this->tableDefinition[] = "{$col} DATETIME DEFAULT CURRENT_TIMESTAMP";

        return $this;
    }

    public function foreignFor(string $tableName): self
    {
        $tableInfo = tableName($tableName);

        $foreignKey = $tableInfo['tableName'] . $tableInfo['primaryKey'];

        $this->tableDefinition[] = "{$foreignKey} INT UNSIGNED";
        $this->tableDefinition[] = "FOREIGN KEY ({$foreignKey}) REFERENCES {$tableInfo['tableName']}({$tableInfo['primaryKey']})";

        return $this;
    }

    public function optional(): self
    {
        $lastIndex = count($this->tableDefinition) - 1;

        $this->tableDefinition[$lastIndex] = str_replace(' NOT NULL', '', $this->tableDefinition[$lastIndex]);

        return $this;
    }

    public function unsigned(): self
    {
        $lastIndex = count($this->tableDefinition) - 1;

        $this->tableDefinition[$lastIndex] = str_replace(' UNSIGNED', '', $this->tableDefinition[$lastIndex]);

        return $this;
    }

    public function default(string $default): self
    {
        $lastIndex = count($this->tableDefinition) - 1;

        $this->tableDefinition[$lastIndex] .= " DEFAULT {$default}";

        return $this;

    }
  
    public function get(): string
    {
        return implode(",\n", $this->tableDefinition);
    }

    public function setPrimaryKey(string $primaryKey): void
    {
        $this->tableInfo['primaryKey'] = $primaryKey;
    }
}

