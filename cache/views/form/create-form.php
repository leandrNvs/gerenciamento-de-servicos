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
  <h1>Criar nova ordem de serviço</h1>

  <form action="<?php echo \Src\Helpers\route('services.store'); ?>" method="POST" class="create-form" autocomplete="off">
    <h2>1. dados do cliente</h2>
    <div class="row">
      
<div class="form-control">
  <div class="label">
    <label for="name">Nome do cliente</label>
    <span class="form-err <?= $view_has_form_err? 'active' : null ?>"><?= $view_form_error_messages['name'] ?? null ?></span>
  </div>
  <div class="input-control">
    <input type="text" name="name" id="name" value="<?= $view_form_data['name'][ 'form-create'] ?? null ?>" />
  </div>
</div>

      
<div class="form-control">
  <div class="label">
    <label for="phone">Telefone</label>
    <span class="form-err <?= $view_has_form_err? 'active' : null ?>"><?= $view_form_error_messages['phone'] ?? null ?></span>
  </div>
  <div class="input-control">
    <input type="text" name="phone" id="phone" value="<?= $view_form_data['phone'][ 'form-create'] ?? null ?>" />
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
    <input type="text" name="cpf" id="cpf" value="<?= $view_form_data['cpf'][ 'form-create'] ?? null ?>" />
  </div>
</div>

      
<div class="form-control">
  <div class="label">
    <label for="address">Endereço</label>
    <span class="form-err <?= $view_has_form_err? 'active' : null ?>"><?= $view_form_error_messages['address'] ?? null ?></span>
  </div>
  <div class="input-control">
    <input type="text" name="address" id="address" value="<?= $view_form_data['address'][ 'form-create'] ?? null ?>" />
  </div>
</div>

    </div>

    <h2>2. dados do veículo</h2>
    <div class="row">
      
<div class="form-control">
  <div class="label">
    <label for="brand">Marca</label>
    <span class="form-err <?= $view_has_form_err? 'active' : null ?>"><?= $view_form_error_messages['brand'] ?? null ?></span>
  </div>
  <div class="input-control">
    <input type="text" name="brand" id="brand" value="<?= $view_form_data['brand'][ 'form-create'] ?? null ?>" />
  </div>
</div>

      
<div class="form-control">
  <div class="label">
    <label for="model">Modelo</label>
    <span class="form-err <?= $view_has_form_err? 'active' : null ?>"><?= $view_form_error_messages['model'] ?? null ?></span>
  </div>
  <div class="input-control">
    <input type="text" name="model" id="model" value="<?= $view_form_data['model'][ 'form-create'] ?? null ?>" />
  </div>
</div>

    </div>
    <div class="row">
      
<div class="form-control">
  <div class="label">
    <label for="year">Ano</label>
    <span class="form-err <?= $view_has_form_err? 'active' : null ?>"><?= $view_form_error_messages['year'] ?? null ?></span>
  </div>
  <div class="input-control">
    <input type="text" name="year" id="year" value="<?= $view_form_data['year'][ 'form-create'] ?? null ?>" />
  </div>
</div>

      
<div class="form-control">
  <div class="label">
    <label for="color">Cor</label>
    <span class="form-err <?= $view_has_form_err? 'active' : null ?>"><?= $view_form_error_messages['color'] ?? null ?></span>
  </div>
  <div class="input-control">
    <input type="text" name="color" id="color" value="<?= $view_form_data['color'][ 'form-create'] ?? null ?>" />
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
    <input type="text" name="plate" id="plate" value="<?= $view_form_data['plate'][ 'form-create'] ?? null ?>" />
  </div>
</div>

      
<div class="form-control">
  <div class="label">
    <label for="km">KM atual</label>
    <span class="form-err <?= $view_has_form_err? 'active' : null ?>"><?= $view_form_error_messages['km'] ?? null ?></span>
  </div>
  <div class="input-control">
    <input type="text" name="km" id="km" value="<?= $view_form_data['km'][ 'form-create'] ?? null ?>" />
  </div>
</div>

      
<div class="form-control">
  <div class="label">
    <label for="fuel">Combustível</label>
    <span class="form-err <?= $view_has_form_err? 'active' : null ?>"><?= $view_form_error_messages['fuel'] ?? null ?></span>
  </div>
  <div class="input-control">
    <input type="text" name="fuel" id="fuel" value="<?= $view_form_data['fuel'][ 'form-create'] ?? null ?>" />
  </div>
</div>

    </div>
    <div>
      
<div class="form-control">
  <div class="label">
    <label for="reported_defect">Problema informado</label>
    <span class="form-err"><?= $view_form_error_messages['reported_defect'] ?? null ?></span>
  </div>
  <div class="input-control textarea">
    <textarea name="reported_defect" id="reported_defect" rows="7"></textarea>
  </div>
</div>

    </div>
    <div>
      
<div class="form-control">
  <div class="label">
    <label for="problem_found">Problema detectado</label>
    <span class="form-err"><?= $view_form_error_messages['problem_found'] ?? null ?></span>
  </div>
  <div class="input-control textarea">
    <textarea name="problem_found" id="problem_found" rows="7"></textarea>
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