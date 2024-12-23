<?php

namespace App\Models;

use Closure;
use Src\Database\Paginate;
use Src\Foundation\Application;
use Src\Support\Database\QueryBuilder;

use function Src\Helpers\tableName;

class Model
{
    protected string $tableName;

    protected string $primaryKey = 'id';

    protected array $alias = [];

    protected array $data = [];

    private array $oldData = [];

    public function __construct(array $data)
    {
        $this->populate($data);
    }

    public function id()
    {
        return $this->{$this->primaryKey};
    }

    public function all()
    {
        return $this->data;
    }

    private function populate(array $data): void
    {
        foreach($data as $key => $value) {
            $this->{$this->alias[$key] ?? $key} = $value;
        }
    }

    public function store()
    {
        $id = QueryBuilder::table(get_class($this))
            ->insert()
            ->execute($this->data);
        
        $this->{$this->primaryKey} = $id;

        return $this;
    }

    public function checkForChanges($data)
    {
        foreach($data as $key => $value) {
            $field = $this->alias[$key] ?? $key;
            
            if($this->{$field} !== $value) {
                $this->oldData[$field] = $this->{$field};
                $this->{$field} = $value;
            }
        }

        return $this;
    }

    public function save()
    {
        unset($this->data['created_at']);

        $result = QueryBuilder::table(get_class($this))
            ->update()
            ->where($this->primaryKey, $this->id())
            ->execute($this->data);

        return $result['rows'];
    }

    public function delete()
    {
        $result = QueryBuilder::table(get_class($this))
            ->delete()
            ->where($this->primaryKey, $this->id())
            ->execute();

        return $result['rows'];
    }

    public function saveAsChild($object)
    {
        $tableInfo = tableName(get_class($this));
        $foreignKey = $tableInfo['tableName'] . $tableInfo['primaryKey'];

        $object->{$foreignKey} = $this->id();
        $object->store();

        return $object;
    }

    public function getChildById($table, $id)
    {
        $tableInfo = tableName(get_class($this));
        $fk  = $tableInfo['tableName'] . $tableInfo['primaryKey'];

        return $table::create(
            QueryBuilder::table($table)
                ->select()
                ->where($fk, $this->id())
                ->execute()['data'][0]
        );
    }

    public static function getById($id)
    {
        return static::create(
            QueryBuilder::table(get_called_class())
                ->select()
                ->where('id', $id)
                ->execute()['data'][0]
        );
    }

    public static function paginate(Closure $closure)
    {
        $paginate = Application::getInstance()->build(Paginate::class, [get_called_class()]);

        $closure($paginate);

        $data = $paginate->execute();

        $data['data'] = array_map(fn($i) => get_called_class()::create($i), $data['data']);

        return [$data['data'], $paginate->createControls($data['totalPages']), $data['totalPages']];
    }

    protected function mutate(): array
    {
        return ['get' => [], 'set' => []];
    }

    public static function create(array $data)
    {
        return new static($data);
    }

    public function __set(string $key, mixed $value): void
    {
        $mutate = $this->mutate()['set'];

        $mutateKeys = array_flip($this->alias);

        $k = $mutateKeys[$key] ?? $key;

        $this->data[$key] = isset($mutate[$k])
            ? $mutate[$k]($value)
            : $value;
    }

    public function __get(string $key): mixed
    {
        $mutate = $this->mutate()['get'];

        if(!isset($this->data[$key])) {
            $this->{$key} = '';
        }

        return isset($mutate[$key])
            ? $mutate[$key]($this->data[$this->alias[$key] ?? $key])
            : $this->data[$this->alias[$key] ?? $key];
    }
}
