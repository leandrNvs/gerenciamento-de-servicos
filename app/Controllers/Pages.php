<?php

namespace App\Controllers;

use App\Models\Service;
use App\Views\Part;
use App\Views\ServiceInfo;
use App\Views\Services;
use Src\Http\Request;

use function Src\Helpers\view;

final class Pages
{
    public static function index(Request $request, $page = 1)
    {
        [$list, $controls, $totalPages] = Services::list($request->getBaseUrl(),'completed', 0, $page, 50);

        $active = 'home';

        return view('home', compact('list', 'controls', 'active', 'totalPages', 'page'));
    }

    public static function index_finished(Request $request, $page = 1)
    {
        [$list, $controls, $totalPages] = Services::list($request->getBaseUrl() . '/finalizados','completed', 1, $page, 50);

        $active = 'finished';

        return view('home', compact('list', 'controls', 'active', 'totalPages', 'page'));
    }

    public static function create()
    {
        return view('form/create-form');
    }

    public static function detail(Service $service)
    {
        $service->infos();
        $service->parts();

        [$info, $totalInfo] = ServiceInfo::detail($service->servicesInfo);
        [$part, $totalPart] = Part::detail($service->parts);

        $totalPrice = number_format(((float) $totalInfo + (float) $totalPart), 2, ',');

        return view('detail', compact('service', 'part', 'totalPart', 'info', 'totalInfo', 'totalPrice'));
    }

    public static function update(Service $service)
    {
        return view('form/update-form', compact('service'));
    }

    public static function service_info(Service $service)
    {
        $service->infos();
        $service->parts();

        $serviceinfo_list = ServiceInfo::list($service);
        $part_list = Part::list($service);

        return view('form/service-form', compact('service', 'serviceinfo_list', 'part_list'));
    }
}
