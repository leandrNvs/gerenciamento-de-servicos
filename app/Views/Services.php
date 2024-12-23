<?php

namespace App\Views;

use App\Models\Service;
use Src\Database\Paginate;

use function Src\Helpers\route;

class Services
{
    public static function list(string $url, string $field, string $value, int $page, int $size = 10)
    {
        [$data, $controls, $totalPages] = Service::paginate(function(Paginate $config) use($field, $value, $size, $page) {
            $config->where    = [$field, $value];
            $config->quantity = $size;
            $config->page     = $page;
        });

        $list = '';

        foreach($data as $service) {
            $detail = route('pages.detail', ['id' => $service->id()]);
            $delete = route('services.delete', ['id' => $service->id()]);
            $update = route('pages.update', ['id' => $service->id()]);
            $completed = route('service.complete', ['id' => $service->id()]);

            $list .= <<<LIST
                <tr data-delete="{$delete}" data-update="{$update}" data-complete="{$completed}" data-id="{$service->id()}" oncontextmenu="boxActions(event, this)">
                    <td>{$service->id()}</td>
                    <td><a href="{$detail}">{$service->name}</a></td>
                    <td>{$service->brand}</td>
                    <td>{$service->model}</td>
                    <td>{$service->color}</td>
                    <td class="problem">{$service->problem_found}</td>
                    <td>{$service->created_at}</td>
                </tr>
            LIST;
        }

        return [$list, $controls->controls($url), $totalPages];
    }

}
