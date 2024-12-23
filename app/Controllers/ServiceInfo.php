<?php

namespace App\Controllers;

use App\Models\Service;
use App\Models\ServiceInfo as ModelsServiceInfo;
use Src\Http\Request;
use Src\Routing\Redirect;
use Src\Validation\Validation;

use function Src\Helpers\success;

final class ServiceInfo
{
    public static function store(Request $request, Service $service)
    {
        Validation::bag('serviceinfo-data');

        $serviceinfo = ModelsServiceInfo::create(
            Validation::validate(ModelsServiceInfo::create_rules(), $request->all())
        );

        $service->saveAsChild($serviceinfo);

        success('Nova informação de serviço adicionada.');

        return Redirect::back();
    }

    public static function delete(Service $service, $info)
    {
        $item = $service->getChildById(ModelsServiceInfo::class, $info);

        $item->delete();
        
        success("Informações sobre o serviço <b>{$item->name}</b> foram apagados.");

        return Redirect::back();
    }

    public static function update(Request $request, Service $service, $info)
    {
        $item = $service->getChildById(ModelsServiceInfo::class, $info);

        $data = (object) Validation::validate(ModelsServiceInfo::update_rules(), $request->all());

        $item->checkForChanges($data);

        $item->save();

        success("Informações sobre o serviço foram atualizados.");

        return Redirect::back();
    }
}
