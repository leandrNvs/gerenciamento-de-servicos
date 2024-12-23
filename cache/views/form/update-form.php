<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JRC - <?=$title;?></title>
    <link rel="stylesheet" href="/assets/css/form.css">
</head>
<body>
    <main class="container">
        








<section class="container">
  <h1>Atualização de dados </h1>

  <div class="filters">
    <div class="panes">
      <a href="<?php echo \Src\Helpers\route('pages.update', ['id' => $service->id]); ?>" class="active">Atualização de dados</a>
      <a href="<?php echo \Src\Helpers\route('pages.update-service', ['id' => $service->id]); ?>">Informações do serviço prestado</a>
    </div>
  </div>

  <form action="<?php echo \Src\Helpers\route('services.update', ['id' => $service->id]); ?>" method="POST" class="part-form" autocomplete="off">
    <?php echo \Src\Helpers\method('put'); ?>
    <?php echo \Src\Helpers\hidden($service->id); ?>
    <h2>1. dados do cliente</h2>
    <div class="row">
      
<div class="form-control">
  <div class="label">
    <label for="name">Nome do cliente</label>
    <span class="form-err <?= $view_has_form_err? 'active' : null ?>"><?= $view_form_error_messages['name'] ?? null ?></span>
  </div>
  <div class="input-control">
    <input type="text" name="name" id="name" value="<?= $view_form_data['name'][ 'form-update'] ?? null ?>" placeholder="<?=htmlspecialchars($service->name);?>" />
  </div>
</div>

      
<div class="form-control">
  <div class="label">
    <label for="phone">Telefone</label>
    <span class="form-err <?= $view_has_form_err? 'active' : null ?>"><?= $view_form_error_messages['phone'] ?? null ?></span>
  </div>
  <div class="input-control">
    <input type="text" name="phone" id="phone" value="<?= $view_form_data['phone'][ 'form-update'] ?? null ?>" placeholder="<?=htmlspecialchars($service->phone);?>" />
  </div>
</div>

    </div>
    <div class="row">
      
<div class="form-control">
  <div class="label">
    <label for="cpf">CPF</label>
    <span class="form-err <?= $view_has_form_err? 'active' : null ?>"><?= $view_form_error_messages['cpf'] ?? null ?></span>
  </div>
  <div class="input-control">
    <input type="text" name="cpf" id="cpf" value="<?= $view_form_data['cpf'][ 'form-update'] ?? null ?>" placeholder="<?=htmlspecialchars($service->cpf);?>" />
  </div>
</div>

      
<div class="form-control">
  <div class="label">
    <label for="address">Endereço</label>
    <span class="form-err <?= $view_has_form_err? 'active' : null ?>"><?= $view_form_error_messages['client_address'] ?? null ?></span>
  </div>
  <div class="input-control">
    <input type="text" name="client_address" id="address" value="<?= $view_form_data['client_address'][ 'form-update'] ?? null ?>" placeholder="<?=htmlspecialchars($service->client_address);?>" />
  </div>
</div>

    </div>

    <h2>2. dados do veículo</h2>
    <div class="row">
      
<div class="form-control">
  <div class="label">
    <label for="brand">Marca</label>
    <span class="form-err <?= $view_has_form_err? 'active' : null ?>"><?= $view_form_error_messages['car_brand'] ?? null ?></span>
  </div>
  <div class="input-control">
    <input type="text" name="car_brand" id="brand" value="<?= $view_form_data['car_brand'][ 'form-update'] ?? null ?>" placeholder="<?=htmlspecialchars($service->car_brand);?>" />
  </div>
</div>

      
<div class="form-control">
  <div class="label">
    <label for="model">Modelo</label>
    <span class="form-err <?= $view_has_form_err? 'active' : null ?>"><?= $view_form_error_messages['car_model'] ?? null ?></span>
  </div>
  <div class="input-control">
    <input type="text" name="car_model" id="model" value="<?= $view_form_data['car_model'][ 'form-update'] ?? null ?>" placeholder="<?=htmlspecialchars($service->car_model);?>" />
  </div>
</div>

    </div>
    <div class="row">
      
<div class="form-control">
  <div class="label">
    <label for="year">Ano</label>
    <span class="form-err <?= $view_has_form_err? 'active' : null ?>"><?= $view_form_error_messages['car_year'] ?? null ?></span>
  </div>
  <div class="input-control">
    <input type="text" name="car_year" id="year" value="<?= $view_form_data['car_year'][ 'form-update'] ?? null ?>" placeholder="<?=htmlspecialchars($service->car_year);?>" />
  </div>
</div>

      
<div class="form-control">
  <div class="label">
    <label for="color">Cor</label>
    <span class="form-err <?= $view_has_form_err? 'active' : null ?>"><?= $view_form_error_messages['car_color'] ?? null ?></span>
  </div>
  <div class="input-control">
    <input type="text" name="car_color" id="color" value="<?= $view_form_data['car_color'][ 'form-update'] ?? null ?>" placeholder="<?=htmlspecialchars($service->car_color);?>" />
  </div>
</div>

    </div>
    <div class="row">
      
<div class="form-control">
  <div class="label">
    <label for="plate">Placa do veículo</label>
    <span class="form-err <?= $view_has_form_err? 'active' : null ?>"><?= $view_form_error_messages['plate'] ?? null ?></span>
  </div>
  <div class="input-control">
    <input type="text" name="plate" id="plate" value="<?= $view_form_data['plate'][ 'form-update'] ?? null ?>" placeholder="<?=htmlspecialchars($service->plate);?>" />
  </div>
</div>

      
<div class="form-control">
  <div class="label">
    <label for="km">KM atual</label>
    <span class="form-err <?= $view_has_form_err? 'active' : null ?>"><?= $view_form_error_messages['car_km'] ?? null ?></span>
  </div>
  <div class="input-control">
    <input type="text" name="car_km" id="km" value="<?= $view_form_data['car_km'][ 'form-update'] ?? null ?>" placeholder="<?=htmlspecialchars($service->car_km);?>" />
  </div>
</div>

      
<div class="form-control">
  <div class="label">
    <label for="fuel">Combustível</label>
    <span class="form-err <?= $view_has_form_err? 'active' : null ?>"><?= $view_form_error_messages['car_fuel'] ?? null ?></span>
  </div>
  <div class="input-control">
    <input type="text" name="car_fuel" id="fuel" value="<?= $view_form_data['car_fuel'][ 'form-update'] ?? null ?>" placeholder="<?=htmlspecialchars($service->car_fuel);?>" />
  </div>
</div>

    </div>
    <div>
      
<div class="form-control">
  <div class="label">
    <label for="reported_defect">Problema informado</label>
    <span class="form-err <?= $view_has_form_err? 'car_reported_defect' : null ?>"><?= $view_form_error_messages['car_reported_defect'] ?? null ?></span>
  </div>
  <div class="input-control textarea">
    <textarea name="car_reported_defect" id="reported_defect" rows="7"></textarea>
  </div>
</div>

    </div>
    <div>
      
<div class="form-control">
  <div class="label">
    <label for="problem_found">Problema detectado</label>
    <span class="form-err <?= $view_has_form_err? 'car_problem_found' : null ?>"><?= $view_form_error_messages['car_problem_found'] ?? null ?></span>
  </div>
  <div class="input-control textarea">
    <textarea name="car_problem_found" id="problem_found" rows="7"></textarea>
  </div>
</div>

    </div>

    <div class="form-buttons">
      <button type="submit">Salvar alterações</button>
      <a href="/">Cancelar</a>
    </div>
  </form>
</section>

    </main>

    <div class="flash-message <?= $view_flash_success? 'success' : 'err' ?>">
        <?= $view_flash_message ?? null ?>
    </div>

    <script src="/assets/js/form.js"></script>
</body>
</html>