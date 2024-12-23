<?php

namespace App\Models;

use Src\Validation\Validation;

final class ServiceInfo extends Model
{
    protected array $alias = [
        'detail' => 'service_detail',
        'price'  => 'service_price',
        'descount' => 'service_descount'
    ];

    public static function create_rules()
    {
        return [
            'detail'   => [Validation::REQUIRED, Validation::TEXT],
            'price'    => [Validation::REQUIRED, Validation::DECIMAL],
            'descount' => [Validation::OPTIONAL, Validation::NUMERIC],
        ];
    }

    public static function update_rules()
    {
        return [
            'detail'   => [Validation::OPTIONAL, Validation::TEXT],
            'price'    => [Validation::OPTIONAL, Validation::DECIMAL],
            'descount' => [Validation::OPTIONAL, Validation::NUMERIC],
        ];
    }

    protected function mutate(): array
    {
        $info = $this;

        return [
            'get' => [
                'price'    => fn($value) => 'R$ ' . str_replace('.', ',', $value),
                'descount' => fn($value) => (float) $value . '%',
                'total'    => function() use($info) {
                    return 'R$ ' . number_format((float) $info->service_price * (1 - (float) $info->service_descount / 100), 2);
                }
           ],
            'set' => [
                'price'    => fn($value) => str_replace(',', '.', $value),
            ]
        ];
    }
}