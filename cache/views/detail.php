<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JRC - Detalhe de serviço</title>
    <link rel="stylesheet" href="/assets/css/detail.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            outline: none;
            box-sizing: border-box;
            font-family: sans-serif;
        }

        body {
            margin: 1rem 0;
        }

        h3 {
            padding: .5rem;
            border-bottom: 1px solid #000;
        }

        main.container {
            border: 1px solid #000;
            max-width: 1000px;
            margin: 0 auto;
        }

        div.row {
            --i: 50% 50%;
            display: grid;
            grid-template-columns: var(--i);
            border-bottom: 1px solid #000;
        }

        div.row > div {
            flex: 1;
            padding: .5rem;
            display: grid;
        }

        div.row > div:not(:last-of-type) {
            border-right: 1px solid #000;
        }

        div.center {
            display: flex !important;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        div.logo {
            background-color: #000;
            color: #fff;
        }

        div.logo h1 {
            text-shadow: 2px 2px 0 dodgerblue;
        }

        .text-center {
            text-align: center;
        }

        p.title {
            text-align: left;
            font-weight: bold;
        }

        p.title + p {
            text-align: center;
            font-size: 1.1rem;
            padding-bottom: .5rem;
        }

        p.title + p.text {
            text-align: justify;
            line-height: 1.5;
            font-size: 1.1rem;
            padding: 1rem;
        }

        table {
            width: 100%;
            margin: 0 1rem;
            text-align: left;
            text-align: center;
            padding-top: .5rem;
        }

        table tbody td {
            padding: .5rem 0;
        }

        div.total {
            justify-self: flex-end;
            width: 100%;
            max-width: 400px;
            padding: .5rem 0;
            border-top: 1px solid #000;
            border-bottom: 0;
            margin-top: 1rem;
        }

        div.total span:first-child {
            font-weight: bold;
        }

        span.row {
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        a {
            position: fixed;
            right: 1rem;
            bottom: 1rem;
            display: block;
            height: 50px;
            width: 50px;
            display: grid;
            place-items: center;
            background-color: #000;
        }

        @media print {
            a {
                display: none;
            }
        }
    </style>
</head>
<body>

    <main class="container">
        <!-- CABEÇALHO DA PÀGINA -->
        <header class="header">
            <div class="row">
                <div class="logo text-center">
                    <h1><?=getenv('LOGO');?></h1>
                    <span><?=getenv('SUBTEXT');?></span>
                </div>
                <div class="center">
                    <h2>Ordem de serviço</h2>
                </div>
            </div>
            <div class="row" style="--i: 50% 1fr 1fr">
                <div class="text-center" style="gap: .2rem">
                    <span><?=getenv('ADDRESS');?></span>
                    <span><?=getenv('PHONE');?></span>
                    <span><?=getenv('CNPJ');?></span>
                </div>
                <div>
                    <p class="title">Nº:</p>
                    <p><?=htmlspecialchars(str_pad($service->id(), 8, 0, STR_PAD_LEFT));?></p>
                </div>
                <div>
                    <p class="title">Data:</p>
                    <p><?=htmlspecialchars($service->created_at);?></p>
                </div>
            </div>
        </header>

        <!-- DADOS DO CLIENTE -->
        <section class="client">
            <h3>Dados do cliente</h3>
            <div class="row">
                <div>
                    <p class="title">Nome:</p>
                    <p><?=htmlspecialchars($service->name);?></p>
                </div>
                <div>
                    <p class="title">CPF:</p>
                    <p><?=htmlspecialchars($service->cpf);?></p>
                </div>
            </div>
            <div class="row">
                <div>
                    <p class="title">Contato:</p>
                    <p><?=htmlspecialchars($service->phone);?></p>
                </div>
                <div>
                    <p class="title">Endereço:</p>
                    <p><?=htmlspecialchars($service->address);?></p>
                </div>
            </div>
        </section>

        <!-- DADOS DO VEÍCULO -->
        <section class="car">
            <h3>Dados do veículo</h3>
            <div class="row" style="--i: repeat(4, 1fr)">
                <div>
                    <p class="title">Placa do veículo:</p>
                    <p><?=htmlspecialchars($service->plate);?></p>
                </div>
                <div>
                    <p class="title">Marca:</p>
                    <p><?=htmlspecialchars($service->brand);?></p>
                </div>
                <div>
                    <p class="title">Modelo:</p>
                    <p><?=htmlspecialchars($service->model);?></p>
                </div>
                <div>
                    <p class="title">Cor:</p>
                    <p><?=htmlspecialchars($service->color);?></p>
                </div>
            </div>
            <div class="row" style="--i: repeat(3, 1fr)">
                <div>
                    <p class="title">Ano:</p>
                    <p><?=htmlspecialchars($service->year);?></p>
                </div>
                <div>
                    <p class="title">KM atual:</p>
                    <p><?=htmlspecialchars($service->km);?></p>
                </div>
                <div>
                    <p class="title">Combustível:</p>
                    <p><?=htmlspecialchars($service->fuel);?></p>
                </div>
            </div>
            <div class="row" style="--i: 1fr">
                <div>
                    <p class="title">Problema informado:</p>
                    <p class="text"><?=htmlspecialchars($service->reported_defect ?? '');?></p>
                </div>
            </div>
            <div class="row" style="--i: 1fr">
                <div>
                    <p class="title">Problema constatado:</p>
                    <p class="text"><?=htmlspecialchars($service->problem_found ?? '');?></p>
                </div>
            </div>
        </section>

        <!-- DADOS DO SERVIÇO -->
        <section class="servicce">
            <h3>Serviços</h3>
            <div class="row" style="--i: 1fr">
                <table>
                    <thead>
                        <tr>
                            <th>Descrição do serviço</th>
                            <th>Desconto</th>
                            <th>Valor</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?=$info;?>
                    </tbody>
                </table>
                <div class="row total" style="--i: 2fr 1fr">
                    <span>Total das peças: </span>
                    <span>R$ <?=$totalInfo;?></span>
                </div>
            </div>
        </section>

        <!-- DADOS DAS PEÇAS -->
        <div class="part">
            <h3>Peças</h3>
            <div class="row" style="--i: 1fr">
                <table>
                    <thead>
                        <tr>
                            <th>Peça</th>
                            <th>Quantidade</th>
                            <th>Valor da unidade</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?=$part;?>
                    </tbody>
                </table>
                <div class="row total" style="--i: 2fr 1fr">
                    <span>Total das peças: </span>
                    <span>R$ <?=$totalPart;?></span>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <footer class="footer">
            <div class="row" style="border-bottom: 0;">
                <div style="position: relative;">
                    <p class="title">DE ACORDO</p>
                    <p style="height: 60px;"></p>
                    <div class="text-center" style="font-weight:bold; padding: .3rem 0; position: absolute; bottom: 0; left: 0; right: 0; border-top: 1px solid #000;">
                        Asasinatura do cliente
                    </div>
                </div>
                <div>
                    <span class="row"><span style="font-weight: bold;">Valor peças:</span> <span>R$ <?=$totalPart;?></span></span>
                    <span class="row"><span style="font-weight: bold;">Valor serviço:</span> <span>R$ <?=$totalInfo;?></span></span>
                    <span class="row"><span style="font-weight: bold;">Valor total:</span> <span>R$ <?=$totalPrice;?></span></span>
                </div>
            </div>
        </footer>
    </main>

    <a href="/">
        <img src="/assets/images/home.svg" alt="ir para a página inicial">
    </a>

</body>
</html>