<?php

namespace App\Models;

use NumberFormatter;
use Src\Validation\Validation;

final class Part extends Model
{
    protected array $alias = [
        'place'  => 'part_place',
        'seller' => 'part_seller',
        'name'   => 'part_name',
        'price'  => 'part_price',
        'quantity'      => 'part_quantity',
        'date_purchase' => 'part_date_purchase',
    ];

    public static function create_rules()
    {
        return [
            'place'    => [Validation::REQUIRED, Validation::ALPHANUMERIC],
            'seller'   => [Validation::REQUIRED, Validation::ALPHA],
            'name'     => [Validation::REQUIRED, Validation::ALPHANUMERIC],
            'price'    => [Validation::REQUIRED, Validation::DECIMAL],
            'quantity' => [Validation::REQUIRED, Validation::NUMERIC],
            'date_purchase' => [Validation::OPTIONAL, Validation::DATE],
        ];
    }

    public static function update_rules()
    {
        return [
            'place'    => [Validation::OPTIONAL, Validation::ALPHANUMERIC],
            'seller'   => [Validation::OPTIONAL, Validation::ALPHA],
            'name'     => [Validation::OPTIONAL, Validation::ALPHANUMERIC],
            'price'    => [Validation::OPTIONAL, Validation::DECIMAL],
            'quantity' => [Validation::OPTIONAL, Validation::NUMERIC],
            'date_purchase' => [Validation::OPTIONAL, Validation::DATE],
        ];
    }

    protected function mutate(): array
    {
        $part = $this;

        return [
            'get' => [
                'date_purchase'  => fn($value) => preg_replace('/^([\d]{4})\-([\d]{2})\-([\d]{2})$/', '$3/$2/$1', $value),
                'price' => fn($value) => 'R$ ' . str_replace('.', ',', $value),
                'total' => function() use($part) {
                    return 'R$ ' . number_format((float) $part->part_price * (int) $part->quantity, 2);
                }
            ],
            'set' => [
                'date_purchase'  => fn($value) => preg_replace('/^([\d]{2})\/([\d]{2})\/([\d]{4})$/', '$3-$2-$1', $value),
                'price'    => fn($value) => str_replace(',', '.', $value),
            ]
        ];
    }
}