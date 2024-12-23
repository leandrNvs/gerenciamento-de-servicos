<?php

namespace App\Views;

use function Src\Helpers\route;

class ServiceInfo
{
    public static function list(mixed $data)
    {
        $list = '';

        foreach ($data->servicesInfo as $info) {
            $delete = route('serviceinfo.delete', ['idservico' => $data->id(), 'idinfo' => $info->id()]);
            $update = route('serviceinfo.update', ['idservico' => $data->id(), 'idinfo' => $info->id()]);
            $d = htmlspecialchars(json_encode($info->all()));

            $list .= <<<LIST
                <tr data-delete="{$delete}" data-update="{$update}" data-id="{$info->id()}" data-data="{$d}">
                    <td>{$info->detail}</td>
                    <td>{$info->descount}</td>
                    <td>{$info->price}</td>
                    <td>{$info->total}</td>
                    <td>
                        <a href="javascript:void(0)" onclick="confirmInfoDelete(event, this.parentElement.parentElement)"><img src="/assets/images/x.svg" alt=""></a>
                        <a href="javascript:void(0)" onclick="updateInfo(event, this.parentElement.parentElement)"><img src="/assets/images/pen.svg" alt=""></a>
                    </td> </tr>
            LIST;
        }

        return $list;
    }

    public static function detail(mixed $data)
    {
        $item = '';

        $total = 0;

        foreach($data as $info) {
            $t = str_replace('R$ ', '', $info->total);

            $total += (int) $t;

            $totalPrice = str_replace('.', ',', $info->total);

            $item .= <<<LIST
                <tr>
                    <td>{$info->detail}</td>
                    <td>{$info->descount}</td>
                    <td>{$info->price}</td>
                    <td>{$totalPrice}</td>
                </tr>
            LIST;
        }

        return [$item, str_replace('.', ',', number_format($total, 2))];
    }
}
