<?php

namespace App\Controllers;

use App\Models\Part;
use App\Models\Service;
use App\Models\ServiceInfo;
use DateTime;
use Src\Database\SchemasDefinition;
use Src\Support\Database\Schemas as DatabaseSchemas;

final class Schemas
{
    public static function index()
    {
        // DatabaseSchemas::create(Service::class, function (SchemasDefinition $table) {
        //     $table->id();

        //     $table->varchar('client_name', 50);
        //     $table->varchar('client_phone', 15);
        //     $table->varchar('client_cpf', 15);
        //     $table->varchar('client_address', 50);

        //     $table->varchar('car_brand', 20);
        //     $table->varchar('car_model', 20);
        //     $table->year('car_year');
        //     $table->varchar('car_license_plate', 15);
        //     $table->varchar('car_color', 20);
        //     $table->varchar('car_km', 15)->optional();
        //     $table->varchar('car_fuel', 15)->optional();
        //     $table->text('car_reported_defect')->optional();
        //     $table->text('car_problem_found')->optional();
        //     $table->bool('completed')->default('false');
        //     $table->created_at('created_at');
        // });

        // DatabaseSchemas::create(ServiceInfo::class, function (SchemasDefinition $table) {
        //     $table->id();
        //     $table->text('service_detail');
        //     $table->decimal('service_price');
        //     $table->smallint('service_descount')->unsigned()->default('0');
        //     $table->foreignFor(Service::class);
        // });

        // DatabaseSchemas::create(Part::class, function (SchemasDefinition $table) {
        //     $table->id();
        //     $table->varchar('part_name')->optional();
        //     $table->varchar('part_seller')->optional();
        //     $table->varchar('part_place')->optional();
        //     $table->decimal('part_price')->optional();
        //     $table->smallint('part_quantity')->optional();
        //     $table->date('part_date_purchase')->optional();
        //     $table->foreignFor(Service::class);
        // });
    }
}
