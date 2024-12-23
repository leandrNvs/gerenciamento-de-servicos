<?php

use App\Controllers\Pages;
use App\Controllers\Part;
use App\Controllers\Schemas;
use App\Controllers\ServiceInfo;
use App\Controllers\Services;
use App\Models\Service;
use Src\Foundation\Application;
use Src\Http\Kernel;
use Src\Support\Routing\Routes;

require_once '../vendor/autoload.php';

$app = new Application(dirname(__DIR__));

Routes::get('/', [Pages::class, 'index'])->name('pages.home');

Routes::get('/pagina/{page}', [Pages::class, 'index'])->name('pages.home-page');

Routes::get('/finalizados/pagina/{page}', [Pages::class, 'index_finished'])->name('pages.home-finished-page');

Routes::get('/finalizados', [Pages::class, 'index_finished'])->name('pages.home-finished');

Routes::get('/servico/{id}', [Pages::class, 'detail'])->name('pages.detail');

Routes::get('/servico/{id}/alterar', [Pages::class, 'update'])->name('pages.update');

Routes::get('/criar-servico', [Pages::class, 'create'])->name('pages.create');

Routes::get('/servico/{id}/alterar-servico', [Pages::class, 'service_info'])->name('pages.update-service');

Routes::get('/servico/{id}/completar', [Services::class, 'complete'])->name('service.complete');

Routes::post('/criar-servico', [Services::class, 'store'])->name('services.store');

Routes::post('/criar-servico-info/{id}', [ServiceInfo::class, 'store'])->name('serviceinfo.store');

Routes::post('/procurar', [Services::class, 'search'])->name('service.search');

Routes::post('/criar-part-info/{id}', [Part::class, 'store'])->name('part.store');

Routes::put('/servico/{id}/alterar', [Services::class, 'update'])->name('services.update');

Routes::put('/servico/{idservico}/part/{idpart}/alterar', [Part::class, 'update'])->name('part.update');

Routes::put('/servico/{idservico}/info/{idinfo}/alterar', [ServiceInfo::class, 'update'])->name('serviceinfo.update');

Routes::delete('/servico/{id}/apagar', [Services::class, 'delete'])->name('services.delete');

Routes::delete('/servico/{idservice}/part/{idpart}', [Part::class, 'delete'])->name('part.delete');

Routes::delete('/servico/{idservice}/info/{idinfo}', [ServiceInfo::class, 'delete'])->name('serviceinfo.delete');

Routes::get('/criar-tabelas', [Schemas::class, 'index'])->name('database.tables');

die($app->build(Kernel::class)->listen());
