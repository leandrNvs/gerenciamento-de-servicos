<?php

namespace App\Models;

use Src\Support\Database\QueryBuilder;
use Src\Validation\Validation;

use function Src\Helpers\tableName;

final class Service extends Model
{
    protected array $alias = [
        'name'    => 'client_name',
        'cpf'     => 'client_cpf',
        'address' => 'client_address',
        'phone'   => 'client_phone',
        'brand'   => 'car_brand',
        'model'   => 'car_model',
        'year'    => 'car_year',
        'color'   => 'car_color',
        'fuel'    => 'car_fuel',
        'km'      => 'car_km',
        'plate'   => 'car_license_plate',
        'problem_found'   => 'car_problem_found',
        'reported_defect' => 'car_reported_defect',
    ];

    public static function create_rules()
    {
        return [
            'name'    => [Validation::REQUIRED, Validation::ALPHA],
            'cpf'     => [Validation::REQUIRED, Validation::CPF, Validation::maxlength(14)],
            'phone'   => [Validation::REQUIRED, Validation::PHONE, Validation::maxlength(15)],
            'address' => [Validation::REQUIRED, Validation::ALPHANUMERIC],
            'brand'   => [Validation::REQUIRED, Validation::ALPHA],
            'model'   => [Validation::REQUIRED, Validation::ALPHA],
            'color'   => [Validation::REQUIRED, Validation::ALPHA],
            'year'    => [Validation::REQUIRED, Validation::YEAR],
            'plate'   => [Validation::REQUIRED, Validation::ALPHANUMERIC],
            'km'      => [Validation::OPTIONAL, Validation::DECIMAL],
            'fuel'    => [Validation::OPTIONAL, Validation::DECIMAL],
            'reported_defect' => [Validation::OPTIONAL, Validation::maxlength(500)],
            'problem_found'   => [Validation::OPTIONAL, Validation::maxlength(500)],
        ];
    }

    public static function update_rules()
    {
        return [
            'name'    => [Validation::OPTIONAL, Validation::ALPHA],
            'cpf'     => [Validation::OPTIONAL, Validation::CPF, Validation::maxlength(14)],
            'phone'   => [Validation::OPTIONAL, Validation::PHONE, Validation::maxlength(15)],
            'address' => [Validation::OPTIONAL, Validation::ALPHANUMERIC],
            'brand'   => [Validation::OPTIONAL, Validation::ALPHA],
            'model'   => [Validation::OPTIONAL, Validation::ALPHA],
            'color'   => [Validation::OPTIONAL, Validation::ALPHA],
            'year'    => [Validation::OPTIONAL, Validation::YEAR],
            'plate'   => [Validation::OPTIONAL, Validation::ALPHANUMERIC],
            'km'      => [Validation::OPTIONAL, Validation::DECIMAL],
            'fuel'    => [Validation::OPTIONAL, Validation::DECIMAL],
            'reported_defect' => [Validation::OPTIONAL, Validation::maxlength(500)],
            'problem_found'   => [Validation::OPTIONAL, Validation::maxlength(500)],
        ];
    }

    public function infos()
    {
        $tableInfo = tableName(get_class($this));

        $foreignKey = $tableInfo['tableName'] . $tableInfo['primaryKey'];

        $info = QueryBuilder::table(ServiceInfo::class)
            ->select()
            ->where($foreignKey, $this->{$this->primaryKey})
            ->execute();

        $this->servicesInfo = array_map(fn($i) => ServiceInfo::create($i), $info['data']);

        return $this;
    }

    public function parts()
    {
        $tableInfo = tableName(get_class($this));

        $foreignKey = $tableInfo['tableName'] . $tableInfo['primaryKey'];

        $info = QueryBuilder::table(Part::class)
            ->select()
            ->where($foreignKey, $this->{$this->primaryKey})
            ->execute();

        $this->parts = array_map(fn($i) => Part::create($i), $info['data']);

        return $this;
    }

    protected function mutate(): array
    {
        return [
            'get' => [
                'name'  => fn($value) => ucwords($value),
                'cpf'   => fn($value) => preg_replace('/^([\d]{3})([\d]{3})([\d]{3})([\d]{2})$/', '$1.$2.$3-$4', $value),
                'phone' => fn($value) => preg_replace('/^([\d]{2})([\d]{5})([\d]{4})$/', '($1) $2-$3', $value),
                'date'  => fn($value) => preg_replace('/^([\d]{2})\-([\d]{2})\-([\d]{4})$/', '$2/$1/$3', $value),
                'fuel'  => fn($value) => str_replace('.', ',', $value) . ' Litros',
                'km'    => fn($value) => str_replace('.', ',', $value) . ' KM',
                'created_at' => fn($value) => preg_replace('/^([\d]{4})\-([\d]{2})\-([\d]{2})(.+?)$/', '$3/$2/$1', $value)
            ],
            'set' => [
                'name'  => fn($value) => strtolower($value),
                'cpf'   => fn($value) => preg_replace('/[\-\.]/', '', $value),
                'phone' => fn($value) => preg_replace('/[\-\s\(\)]/', '', $value),
                'date'  => fn($value) => preg_replace('/^([\d]{2})\/([\d]{2})\/([\d]{4})$/', '$2-$1-$3', $value),
                'fuel'  => fn($value) => $value? str_replace(' Litros', '', str_replace(',', '.', $value)) : '' ,
                'km'    => fn($value) => $value? str_replace(' KM', '', str_replace(',', '.', $value)) : '' 
            ]
        ];
    }
}
