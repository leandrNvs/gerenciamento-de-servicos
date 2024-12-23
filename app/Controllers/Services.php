<?php

namespace App\Controllers;

use App\Models\Service;
use App\Views\Services as ViewsServices;
use Exception;
use Src\Http\Request;
use Src\Support\Database\QueryBuilder;
use Src\Validation\Validation;

use function Src\Helpers\route;
use function Src\Helpers\success;
use function Src\Helpers\to_route;

final class Services
{
    public static function store(Request $request)
    {
        $service = Service::create(Validation::validate(Service::create_rules(), $request->all()));

        $service->store();

        success('Novo serviço para ' . $service->name  . ' foi criado.');

        return to_route('pages.home');
    }

    public static function update(Request $request, Service $service)
    {
        $data = (object) Validation::validate(Service::update_rules(), $request->all());

        $service->checkForChanges($data);

        $service->save();
        
        success('Alterações nos dados de serviço para ' . $service->name  . ' foram salvas.');

        return to_route('pages.home');
    }

    public static function delete(Request $request, Service $service)
    {
        if($request->input('id') != $service->id()) throw new Exception('Not allowed');

        $service->delete();

        success('Ordem de serviço de ' . $service->name  . ' foi apagada.');

        return to_route('pages.home');
    }

    public static function complete(Service $service)
    {
        $service->completed = $service->completed === 0? 1 : 0;

        $service->save();

        success('Ordem de serviço de ' . $service->name  . ' foi marcada como completada.');

        return to_route('pages.home');
    }

    public static function search(Request $request)
    {
        if(preg_match_all('/@(.+?):(.+)/', $request->input('search'), $match)) {

            $fields = [
               'nome'    => 'client_name',
               'marca'   => 'car_brand',
               'modelo'  => 'car_model',
               'cpf'     => 'client_cpf',
               'servico' => 'id',
            ];

            $data = QueryBuilder::table(Service::class)
                ->select()
                ->where($fields[end($match[1])], 'like', end($match[2]).'%')
                ->execute();

            $data = array_map(function($i) {
                $detail = route('pages.detail', ['id' => $i['id']]);
                $delete = route('services.delete', ['id' => $i['id']]);
                $update = route('pages.update', ['id' => $i['id']]);
                $completed = route('service.complete', ['id' => $i['id']]);
                $status = $i['completed'] === 0? 'em andamento' : 'completo';
                $cpf = preg_replace('/([\d]{3})([\d]{3})([\d]{3})([\d]{2})/', '$1.$2.$3-$4', $i['client_cpf']);

                return <<<ITEM
                  <a href="/detalhes/{$i['id']}" data-delete="{$delete}" data-update="{$update}" data-complete="{$completed}" data-id="{$i['id']}" oncontextmenu="boxActions(event, this)">
                    <div>
                      <span>ID</span>
                      <span>{$i['id']}</span>
                    </div>
                    <div>
                      <span>Nome</span>
                      <span>{$i['client_name']}</span>
                    </div>
                    <div>
                      <span>cpf</span>
                      <span>{$cpf}</span>
                    </div>
                    <div>
                      <span>Marca</span>
                      <span>{$i['car_brand']}</span>
                    </div>
                    <div>
                      <span>Modelo</span>
                      <span>{$i['car_model']}</span>
                    </div>
                    <div>
                      <span>Placa</span>
                      <span>{$i['car_license_plate']}</span>
                    </div>
                    <div>
                      <span>Status</span>
                      <span>{$status}</span>
                    </div>
                  </a>
                ITEM;
            }, $data['data']);
            
            return json_encode(implode('', $data));
        }

        return json_encode(false);
    }
}
