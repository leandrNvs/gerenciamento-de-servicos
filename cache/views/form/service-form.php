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
        







<section class="section-delete">
  <form action="" method="post" autocomplete="off" class="delete-form">
    <?php echo \Src\Helpers\method('delete'); ?>
    <?php echo \Src\Helpers\hidden('id'); ?>
    <h2></h2>
    <div class="content">
      <p>Tem certeza que deseja apagar os dados de <b></b>?</p>
    </div>
    <div class="form-button">
      <button type="submit">Confirmar</button>
      <a href="javascript:void(0)"
        onclick="this.parentElement.parentElement.parentElement.classList.remove('active')">Cancelar</a>
    </div>
  </form>
</section>

<section class="container">
  <h1>Atualização de dados</h1>

  <div class="filters">
    <div class="panes">
      <a href="<?php echo \Src\Helpers\route('pages.update', ['id' => $service->id]); ?>">Atualização de dados</a>
      <a href="<?php echo \Src\Helpers\route('pages.update-service', ['id' => $service->id]); ?>" class="active">Informações do serviço prestado</a>
    </div>
  </div>

  <h2>1. informações sobre o serviço prestado</h2>

  <table>
    <thead>
      <tr>
        <th>Serviço prestado</th>
        <th>Desconto</th>
        <th>Valor do serviço</th>
        <th>Total</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      <?=$serviceinfo_list;?>
    </tbody>
  </table>

  <form action="<?php echo \Src\Helpers\route('serviceinfo.store', ['id' => $service->id]); ?>" class="form-serviceinfo" method="POST" autocomplete="off">
    <div>
      
<div class="form-control">
  <div class="label">
    <label for="service_detail">Descrição do serviço</label>
    <span class="form-err <?= $view_has_form_err? 'active' : null ?>"><?= $view_form_error_messages['serviceinfo-data'][ 'detail'] ?? null ?></span>
  </div>
  <div class="input-control textarea">
    <textarea name="detail" id="service_detail" rows="7"><?= $view_form_data['serviceinfo-data'][ 'detail'] ?? null ?></textarea>
  </div>
</div>

    </div>
    <div class="row">
      
<div class="form-control">
  <div class="label">
    <label for="service_price">Valor do serviço</label>
    <span class="form-err <?= $view_has_form_err? 'active' : null ?>"><?= $view_form_error_messages['serviceinfo-data'][ 'price'] ?? null ?></span>
  </div>
  <div class="input-control">
    <input type="$type" name="price" id="service_price" value="<?= $view_form_data['serviceinfo-data'][ 'price'] ?? null ?>" />
  </div>
</div>

      
<div class="form-control">
  <div class="label">
    <label for="service_descount">Desconto aplicado</label>
    <span class="form-err <?= $view_has_form_err? 'active' : null ?>"><?= $view_form_error_messages['serviceinfo-data'][ 'descount'] ?? null ?></span>
  </div>
  <div class="input-control">
    <input type="$type" name="descount" id="service_descount" value="<?= $view_form_data['serviceinfo-data'][ 'descount'] ?? null ?>" />
  </div>
</div>

    </div>

    <div class="form-buttons">
      <button type="submit">Adicionar informações</button>
      <a href="/">Cancelar</a>
    </div>
  </form>
</section>

<section class="container" style="margin-top: 2rem;">
  <h2>2. informações sobre as peças</h2>

  <table>
    <thead>
      <tr>
        <th>Local da compra</th>
        <th>Vendedor</th>
        <th>Data da compra</th>
        <th>Peça</th>
        <th>Quantidade</th>
        <th>Preço</th>
        <th>Total</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      <?=$part_list;?>
    </tbody>
  </table>

  <form action="<?php echo \Src\Helpers\route('part.store', ['id' => $service->id]); ?>" method="POST" class="form-part" autocomplete="off">
    <div class="row">
      
<div class="form-control">
  <div class="label">
    <label for="part_seller">Nome do vendedor</label>
    <span class="form-err <?= $view_has_form_err? 'active' : null ?>"><?= $view_form_error_messages['part-data'][ 'seller'] ?? null ?></span>
  </div>
  <div class="input-control">
    <input type="$type" name="seller" id="part_seller" value="<?= $view_form_data['part-data'][ 'seller'] ?? null ?>" />
  </div>
</div>

      
<div class="form-control">
  <div class="label">
    <label for="part_place">Local da compra</label>
    <span class="form-err <?= $view_has_form_err? 'active' : null ?>"><?= $view_form_error_messages['part-data'][ 'place'] ?? null ?></span>
  </div>
  <div class="input-control">
    <input type="$type" name="place" id="part_place" value="<?= $view_form_data['part-data'][ 'place'] ?? null ?>" />
  </div>
</div>

      
<div class="form-control">
  <div class="label">
    <label for="part_date_purchase">Data da compra</label>
    <span class="form-err <?= $view_has_form_err? 'active' : null ?>"><?= $view_form_error_messages['part-data'][ 'date_purchase'] ?? null ?></span>
  </div>
  <div class="input-control">
    <input type="$type" name="date_purchase" id="part_date_purchase" value="<?= $view_form_data['part-data'][ 'date_purchase'] ?? null ?>" />
  </div>
</div>

    </div>
    <div class="row">
      
<div class="form-control">
  <div class="label">
    <label for="part_name">Peça</label>
    <span class="form-err <?= $view_has_form_err? 'active' : null ?>"><?= $view_form_error_messages['part-data'][ 'name'] ?? null ?></span>
  </div>
  <div class="input-control">
    <input type="$type" name="name" id="part_name" value="<?= $view_form_data['part-data'][ 'name'] ?? null ?>" />
  </div>
</div>

      
<div class="form-control">
  <div class="label">
    <label for="part_price">Valor da peça</label>
    <span class="form-err <?= $view_has_form_err? 'active' : null ?>"><?= $view_form_error_messages['part-data'][ 'price'] ?? null ?></span>
  </div>
  <div class="input-control">
    <input type="$type" name="price" id="part_price" value="<?= $view_form_data['part-data'][ 'price'] ?? null ?>" />
  </div>
</div>

      
<div class="form-control">
  <div class="label">
    <label for="part_quantity">Quantidade comprada</label>
    <span class="form-err <?= $view_has_form_err? 'active' : null ?>"><?= $view_form_error_messages['part-data'][ 'quantity'] ?? null ?></span>
  </div>
  <div class="input-control">
    <input type="$type" name="quantity" id="part_quantity" value="<?= $view_form_data['part-data'][ 'quantity'] ?? null ?>" />
  </div>
</div>

    </div>

    <div class="form-buttons">
      <button type="submit">Adicionar informações</button>
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