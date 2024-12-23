<?php

namespace App\Controllers;

use App\Models\Part as ModelsPart;
use App\Models\Service;
use App\Views\Part as ViewsPart;
use Src\Http\Request;
use Src\Routing\Redirect;
use Src\Validation\Validation;

use function Src\Helpers\success;

final class Part
{
    public static function store(Request $request, Service $service)
    {
        Validation::bag('part-data');

        $part = ModelsPart::create(
            Validation::validate(ModelsPart::create_rules(), $request->all())
        );

        $service->saveAsChild($part);

        success("Informações sobre a peça <b>{$part->name}</b> foram adicionadas.");

        return Redirect::back();

    }

    public static function delete(Service $service, $part)
    {
        $item = $service->getChildById(ModelsPart::class, $part);

        $item->delete();
        
        success("Informações sobre a peça <b>{$item->name}</b> foram apagados.");

        return Redirect::back();
    }

    public static function update(Request $request, Service $service, $part)
    {
        $item = $service->getChildById(ModelsPart::class, $part);

        $data = (object) Validation::validate(ModelsPart::update_rules(), $request->all());

        $item->checkForChanges($data);

        $item->save();

        success("Informações sobre a peça <b>{$item->name}</b> foram atualizados.");

        return Redirect::back();
    }
}
