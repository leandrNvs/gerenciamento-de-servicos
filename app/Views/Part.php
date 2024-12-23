<?php

namespace App\Views;

use NumberFormatter;

use function Src\Helpers\route;

class Part
{
    public static function list(mixed $data)
    {
        $list = '';

        foreach($data->parts as $part) {
            $delete = route('part.delete', ['idservico' => $data->id(), 'idpart' => $part->id()]);
            $update = route('part.update', ['idservico' => $data->id(), 'idpart' => $part->id()]);
            $d = htmlspecialchars(json_encode($part->all()));

            $list .= <<<LIST
                <tr data-delete="{$delete}" data-update="{$update}" data-id="{$part->id()}" data-data="{$d}">
                    <td>{$part->place}</td>
                    <td>{$part->seller}</td>
                    <td>{$part->date_purchase}</td>
                    <td>{$part->name}</td>
                    <td>{$part->quantity}</td>
                    <td>{$part->price}</td>
                    <td>{$part->total}</td>
                    <td>
                        <a href="javascript:void(0)" onclick="confirmPartDelete(event, this.parentElement.parentElement)"><img src="/assets/images/x.svg" alt=""></a>
                        <a href="javascript:void(0)" onclick="updatePart(event, this.parentElement.parentElement)"><img src="/assets/images/pen.svg" alt=""></a>
                    </td>
                </tr>
            LIST;
        }

        return $list;
    }

    public static function detail(mixed $data)
    {
        $item = '';

        $total = 0;

        foreach($data as $part) {
            $t = str_replace('R$ ', '', $part->total);

            $total += (int) $t;

            $totalPrice = str_replace('.', ',', $part->total);

            $item .= <<<LIST
                <tr>
                    <td>{$part->name}</td>
                    <td>{$part->quantity}</td>
                    <td>{$part->price}</td>
                    <td>{$totalPrice}</td>
                </tr>
            LIST;
        }

        return [$item, str_replace('.', ',', number_format($total, 2))];
    }

}
