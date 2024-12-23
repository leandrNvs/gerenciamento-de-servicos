<!DOCTYPE html>
<html lang="en">
<head>
    <base href="">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JRC - <?=$title;?></title>
    <link rel="stylesheet" href="/assets/css/home.css">
</head>
<body>
    



<main class="container">
    <!-- FORMULÁRIO PARA EXCLUSÃO DE DADOS -->
    <section class="section-delete">
        <form action="" method="post" autocomplete="off" class="delete-form">
            <?php echo \Src\Helpers\method('delete'); ?>
            <?php echo \Src\Helpers\hidden('id'); ?>
            <h2>Confirmar a exclusão serviço</h2>
            <div class="content">
                <p>Tem certeza que deseja apagar os dados de <b></b>?</p>
            </div>
            <div class="form-button">
                <button type="submit">Confirmar</button>
                <a href="javascript:void(0)" onclick="this.parentElement.parentElement.parentElement.classList.remove('active')">Cancelar</a>
            </div>
        </form>
    </section>

    <!-- CONTEÚDO PRINCIPAL -->
    <section class="section-content">
        <header class="header">
            <h1>Ordens de serviços</h1>
            <a href="<?php echo \Src\Helpers\route('pages.create'); ?>">Adicionar novo serviço</a>
        </header>

        <div class="middle">
            <nav class="nav">
                <a href="<?php echo \Src\Helpers\route('pages.home'); ?>" class="nav-link <?=$active === 'home'? 'active' : null;?>">Serviços em andamento</a>
                <a href="<?php echo \Src\Helpers\route('pages.home-finished'); ?>" class="nav-link  <?=$active === 'finished'? 'active' : null;?>">Serviços concluídos</a>
            </nav>

            <form action="<?php echo \Src\Helpers\route('service.search'); ?>" method="post" autocomplete="off" class="search-form">
                <input type="hidden" name="url" value="">
                <input type="search" name="search" placeholder="Procure por..." onkeyup="filter(event, this)" list="filter" />
                <datalist id="filter">
                  <option value="@nome:"></option>
                  <option value="@marca:"></option>
                  <option value="@modelo:"></option>
                  <option value="@placa:"></option>
                  <option value="@cpf:"></option>
                  <option value="@servico:"></option>
                </datalist>
                <div class="search-results">
                </div>
            </form>
        </div>

        <!-- LISTAGEM DE SERVIÇOS -->
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Cor</th>
                    <th>Problema</th>
                    <th>Data de entrada</th>
                </tr>
            </thead>
            <tbody>
                <?=$list;?>
            </tbody>
        </table>

        <!-- PAGINAÇÃO -->
        <footer class="paginate">
            <?php if($totalPages > 0): ?>
                <span>Exibindo página <?=$page;?> de <?=$totalPages;?></span>
                <div>
                    <?=$controls;?>
                </div>
            <?php endif; ?>
        </footer>
    </section>
</main>

<div class="boxActions">
    <a href="javascript:void(0)">Delete item</a>
    <a href="javascript:void(0)">Atualizar dados</a>
    <a href="javascript:void(0)">Marcar/Desmarcar finalizado</a>
</div>


    <div class="flash-message <?= $view_flash_success? 'success' : 'err' ?>">
        <?= $view_flash_message ?? null ?>
    </div>

    <script src="/assets/js/home.js"></script>
</body>
</html>