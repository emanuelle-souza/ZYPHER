<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras</title>
    <link rel="stylesheet" href="../css/menu.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: Arial, sans-serif;
        }
        main {
            flex: 1 0 auto;
        }
        .container-carrinho {
            max-width: 700px;
            margin: 60px auto 40px auto;
            padding: 32px 24px;
            background: #f4f4f4;
            border-radius: 14px;
            box-shadow: 0 0 16px rgba(0,0,0,0.10);
        }
        .container-carrinho h2 {
            text-align: center;
            margin-bottom: 28px;
            color: #222;
            letter-spacing: 1px;
        }
        .item-carrinho {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
            border-radius: 10px;
            margin-bottom: 18px;
            padding: 16px 18px;
            box-shadow: 0 2px 8px rgba(40,167,69,0.07);
            transition: box-shadow 0.2s;
        }
        .item-carrinho:hover {
            box-shadow: 0 4px 16px rgba(40,167,69,0.13);
        }
        .item-info {
            display: flex;
            align-items: center;
            gap: 18px;
        }
        .item-info img {
            width: 70px;
            height: 70px;
            object-fit: contain;
            border-radius: 8px;
            background: #e4e4e4;
        }
        .item-nome {
            font-size: 1.1em;
            font-weight: bold;
            color: #222;
        }
        .item-preco {
            color: #28a745;
            font-weight: bold;
            font-size: 1.1em;
        }
        .item-qtd {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .item-qtd button {
            background: #e4e4e4;
            border: none;
            border-radius: 4px;
            width: 26px;
            height: 26px;
            font-size: 1.1em;
            cursor: pointer;
            color: #222;
            transition: background 0.2s;
        }
        .item-qtd button:hover {
            background: #28a745;
            color: #fff;
        }
        .item-qtd span {
            min-width: 22px;
            text-align: center;
            display: inline-block;
        }
        .item-remover {
            background: none;
            border: none;
            color: #e74c3c;
            font-size: 1.2em;
            cursor: pointer;
            margin-left: 18px;
            transition: color 0.2s;
        }
        .item-remover:hover {
            color: #c0392b;
        }
        .carrinho-total {
            text-align: right;
            font-size: 1.2em;
            font-weight: bold;
            margin-top: 18px;
            color: #222;
        }
        .carrinho-vazio {
            text-align: center;
            color: #888;
            font-size: 1.1em;
            margin: 40px 0;
        }
        .btn-finalizar {
            display: block;
            margin: 32px auto 0 auto;
            background: #28a745;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 14px 38px;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 8px rgba(40,167,69,0.07);
        }
        .btn-finalizar:hover {
            background: #1e7e34;
        }
        /* Header, pesquisar, icones, rodape (copiados do modelo) */
        .pesquisar {
            display: flex;
            align-items: center;
            background: #e4e4e4;
            border-radius: 24px;
            padding: 2px 10px 2px 12px;
            width: 240px;
            height: 38px;
        }
        .pesquisar input[type="text"] {
            border: none;
            background: transparent;
            outline: none;
            font-size: 1em;
            flex: 1;
            padding: 6px 0;
            color: #222;
        }
        .pesquisar button {
            background: none;
            border: none;
            padding: 0;
            margin-left: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
        }
        .pesquisar button img {
            width: 20px;
            height: 20px;
            filter: grayscale(1) brightness(0.6);
            display: block;
        }
        .icones a img {
            vertical-align: middle;
        }
        footer {
            background: #f4f4f4;
            text-align: center;
            padding: 20px 0;
            margin-top: 40px;
            flex-shrink: 0;
            width: 100%;
        }
        .rodape .text a {
            text-decoration: none;
            color: #888;
            font-family: Arial, sans-serif;
            font-size: 15px;
        }
X        /* Estilização dos formulários de pagamento */
        #form-pagamento {
            background: #fff;
            border-radius: 12px;
            padding: 24px 18px 18px 18px;
            box-shadow: 0 2px 12px rgba(40,167,69,0.07);
            max-width: 420px;
            margin: 0 auto;
            margin-top: 18px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        #form-pagamento label {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.08em;
            font-weight: 500;
            color: #222;
            margin-bottom: 4px;
            cursor: pointer;
            padding: 6px 0 2px 0;
            border-radius: 6px;
            transition: background 0.2s;
        }
        #form-pagamento label:hover {
            background: #f4f4f4;
        }
        #form-pagamento input[type="radio"] {
            accent-color: #28a745;
            width: 18px;
            height: 18px;
            margin-right: 6px;
            cursor: pointer;
        }
        #form-pagamento input[type="text"] {
            border: 1.5px solid #ccc;
            border-radius: 8px;
            padding: 12px 14px 12px 44px;
            font-size: 1em;
            color: #222;
            background: #f8f8f8;
            margin-bottom: 8px;
            transition: border 0.2s, box-shadow 0.2s;
            outline: none;
            box-sizing: border-box;
        }
        #form-pagamento input[type="text"]:focus {
            border: 1.5px solid #28a745;
            box-shadow: 0 0 0 2px #b6f5c9;
            background-color: #f8fff9;
        }
        #cartao-fields input[type="text"] {
            background-color: #f8f8f8;
        }
        #cartao-fields input[type="text"]:focus {
            background-color: #f8fff9;
        }
        #bandeira-cartao {
            min-height: 24px;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }
        #pix-fields input[type="text"] {
            background-color: #f8f8f8;
        }
        .btn-finalizar, #form-pagamento button[type="submit"] {
            width: 100%;
            padding: 14px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 8px rgba(40,167,69,0.07);
            letter-spacing: 1px;
        }
        .btn-finalizar:hover, #form-pagamento button[type="submit"]:hover {
            background-color: #1e7e34;
        }
        /* Placeholder mais suave */
        #form-pagamento input[type="text"]::placeholder {
            color: #aaa;
            opacity: 1;
            font-size: 0.97em;
        }
        /* Suaviza o visual do container de pagamento */
        #pagamento {
            background: #f4f4f4;
            border-radius: 14px;
            box-shadow: 0 0 16px rgba(0,0,0,0.10);
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <header>
        <div class="menu-container">
            <div class="logo">
                <a class="logo" href="#"><img src="../MIDIA/LogoDeitado.png.png" alt="Logo Zypher Sneakers"></a>
            </div>
            <div class="pesquisar">
                <input type="text" placeholder="Pesquisar...">
                <button>
                    <img src="https://cdn-icons-png.flaticon.com/512/622/622669.png" alt="Pesquisar">
                </button>
            </div>
            <div class="icones">
                <a class="coroa" href="/zypher/views/SejaMembro.php">
                    <img src="https://cdn-icons-png.flaticon.com/512/6941/6941697.png" alt="coroa" width="32" height="32" style="filter: drop-shadow(0 1px 2px #bfa13b88);">
                </a>
                <a class="perfil" href="/zypher/views/PerfilUsuario.php">
                    <img src="https://cdn-icons-png.flaticon.com/512/1077/1077114.png" alt="perfil" width="32" height="32" style="filter: grayscale(1) brightness(0.6);">
                </a>
                <a class="carrinho" href="/zypher/views/CarrinhoCliente.php">
                    <img src="https://cdn-icons-png.flaticon.com/512/3514/3514491.png" alt="carrinho" width="32" height="32" style="filter: grayscale(1) brightness(0.6);">
                </a>
            </div>
        </div>
        <nav class="menu-categorias">
            <ul>
                <li><a href="#">FEMININO</a></li>
                <li><a href="#">MASCULINO</a></li>
                <li><a href="#">INFANTIL</a></li>
                <li><a href="#">ESPORTE</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <div class="container-carrinho" id="carrinho">
            <h2>Seu Carrinho</h2>
            <div id="itens-carrinho"></div>
            <div class="carrinho-total" id="carrinho-total"></div>
            <button class="btn-finalizar" id="btn-finalizar" style="display:none;">Finalizar Compra</button>
        </div>
        <div class="container-carrinho" id="pagamento" style="display:none;">
            <h2>Pagamento</h2>
            <form id="form-pagamento" autocomplete="off">
                <label>
                    <input type="radio" name="pagamento" value="credito" checked> Cartão de Crédito
                </label>
                <label>
                    <input type="radio" name="pagamento" value="debito"> Cartão de Débito
                </label>
                <label>
                    <input type="radio" name="pagamento" value="pix"> Pix
                </label>
                <div id="cartao-fields" style="margin-top:18px;">
                    <input type="text" id="numero-cartao" maxlength="19" placeholder="Número do cartão" style="width:100%;margin-bottom:12px;padding-left:44px;background-image:url('https://cdn-icons-png.flaticon.com/512/633/633611.png');background-size:22px 22px;background-repeat:no-repeat;background-position:12px 50%;">
                    <div id="bandeira-cartao" style="margin-bottom:12px;height:24px;"></div>
                    <input type="text" id="nome-cartao" placeholder="Nome impresso no cartão" style="width:100%;margin-bottom:12px;">
                    <input type="text" id="validade-cartao" maxlength="5" placeholder="Validade (MM/AA)" style="width:48%;margin-right:4%;margin-bottom:12px;">
                    <input type="text" id="cvv-cartao" maxlength="4" placeholder="CVV" style="width:48%;margin-bottom:12px;">
                </div>
                <div id="pix-fields" style="display:none;margin-top:18px;">
                    <input type="text" placeholder="Chave Pix ou QR Code" style="width:100%;margin-bottom:12px;">
                </div>
                <button type="submit" class="btn-finalizar" style="margin-top:18px;">Pagar</button>
            </form>
            <div id="pagamento-sucesso" style="display:none;text-align:center;color:#28a745;font-weight:bold;font-size:1.2em;margin-top:24px;">
                Verificando pagamento e dados...
            </div>
        </div>
    </main>

    <footer>
        <div class="rodape">
            <p class="text"><a href="#">© 2025 Zypher Company. Todos os direitos reservados.</a></p>
        </div>
    </footer>

    <script>
        // Produtos de exemplo
        const produtos = [
            {
                id: 1,
                nome: "Nike Air Max 90",
                preco: 599.90,
                imagem: "https://static.dafiti.com.br/p/Nike-T%C3%AAnis-Nike-Air-Max-90-Masculino-5172-16910211-1-zoom.jpg"
            },
            {
                id: 2,
                nome: "Adidas Ultraboost",
                preco: 749.90,
                imagem: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRCWPcAe_L_lzTqzHUz-jbA_VK5V70xTEHLZA&s"
            },
            {
                id: 3,
                nome: "Vans Old Skool",
                preco: 349.90,
                imagem: "https://secure-static.vans.com.br/medias/sys_master/vans/vans/h5c/hab/h00/h00/12093774790686/1002002130020U-01-BASEIMAGE-Midres.jpg"
            }
        ];

        // Carrinho inicial (simulação)
        let carrinho = [
            { ...produtos[0], qtd: 1 },
            { ...produtos[1], qtd: 1 },
            { ...produtos[2], qtd: 1 },
           

            
            // Adicionando mais um item do primeiro produto
        ];

        // Limite máximo de produtos por item
        const LIMITE_PRODUTO = 5;

        // Carrega o carrinho do localStorage, se existir
        function carregarCarrinho() {
            const salvo = localStorage.getItem('carrinho');
            if (salvo) {
                try {
                    carrinho = JSON.parse(salvo);
                } catch {
                    carrinho = [];
                }
            }
        }

        // Salva o carrinho no localStorage
        function salvarCarrinho() {
            localStorage.setItem('carrinho', JSON.stringify(carrinho));
        }

        function renderCarrinho() {
            const itensDiv = document.getElementById('itens-carrinho');
            const totalDiv = document.getElementById('carrinho-total');
            const btnFinalizar = document.getElementById('btn-finalizar');
            itensDiv.innerHTML = '';
            let total = 0;

            if (carrinho.length === 0) {
                itensDiv.innerHTML = '<div class="carrinho-vazio">Seu carrinho está vazio.</div>';
                totalDiv.textContent = '';
                btnFinalizar.style.display = 'none';
                return;
            }

            carrinho.forEach((item, idx) => {
                total += item.preco * item.qtd;
                const itemDiv = document.createElement('div');
                itemDiv.className = 'item-carrinho';
                itemDiv.innerHTML = `
                    <div class="item-info">
                        <img src="${item.imagem}" alt="${item.nome}">
                        <div>
                            <div class="item-nome">${item.nome}</div>
                            <div class="item-preco">R$ ${item.preco.toFixed(2)}</div>
                        </div>
                    </div>
                    <div class="item-qtd">
                        <button onclick="alterarQtd(${idx}, -1)">-</button>
                        <span>${item.qtd}</span>
                        <button onclick="alterarQtd(${idx}, 1)" ${item.qtd >= LIMITE_PRODUTO ? 'disabled style="opacity:0.5;cursor:not-allowed;"' : ''}>+</button>
                        <button class="item-remover" title="Remover" onclick="removerItem(${idx})">&times;</button>
                    </div>
                `;
                itensDiv.appendChild(itemDiv);
            });

            totalDiv.textContent = "Total: R$ " + total.toFixed(2);
            btnFinalizar.style.display = 'block';
        }

        // Altera quantidade pelo índice do item no array
        function alterarQtd(idx, delta) {
            let item = carrinho[idx];
            if (!item) return;
            let novaQtd = item.qtd + delta;
            if (novaQtd < 1) {
                carrinho.splice(idx, 1);
            } else if (novaQtd > LIMITE_PRODUTO) {
                carrinho[idx].qtd = LIMITE_PRODUTO;
            } else {
                carrinho[idx].qtd = novaQtd;
            }
            salvarCarrinho();
            renderCarrinho();
        }

        // Remove item pelo índice
        function removerItem(idx) {
            carrinho.splice(idx, 1);
            salvarCarrinho();
            renderCarrinho();
        }

        // Ao clicar em "Finalizar Compra"
        document.getElementById('btn-finalizar').onclick = function() {
            document.getElementById('carrinho').style.display = 'none';
            document.getElementById('pagamento').style.display = 'block';
        };

        // Carrega o carrinho salvo e exibe
        carregarCarrinho();
        renderCarrinho();

        // Componentização pagamento
        const formPagamento = document.getElementById('form-pagamento');
        const cartaoFields = document.getElementById('cartao-fields');
        const pixFields = document.getElementById('pix-fields');
        const bandeiraDiv = document.getElementById('bandeira-cartao');
        const numeroCartao = document.getElementById('numero-cartao');
        const pagamentoSucesso = document.getElementById('pagamento-sucesso');

        // Alterna campos conforme método de pagamento
        formPagamento.pagamento.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'pix') {
                    cartaoFields.style.display = 'none';
                    pixFields.style.display = 'block';
                } else {
                    cartaoFields.style.display = 'block';
                    pixFields.style.display = 'none';
                }
            });
        });

        // Detecta bandeira do cartão
        numeroCartao.addEventListener('input', function() {
            const val = numeroCartao.value.replace(/\D/g, '');
            let bandeira = '';
            let img = '';
            if (/^4/.test(val)) {
                bandeira = 'Visa';
                img = 'https://logodownload.org/wp-content/uploads/2016/10/visa-logo-1.png';
            } else if (/^5[1-5]/.test(val)) {
                bandeira = 'Mastercard';
                img = 'https://logodownload.org/wp-content/uploads/2014/07/mastercard-logo-4.png';
            } else if (/^3[47]/.test(val)) {
                bandeira = 'American Express';
                img = 'https://logodownload.org/wp-content/uploads/2017/04/american-express-logo-1.png';
            } else if (/^6(?:011|5)/.test(val)) {
                bandeira = 'Discover';
                img = 'https://upload.wikimedia.org/wikipedia/commons/5/5a/Discover_Card_logo.svg';
            } else if (/^(4011|4389|4576|5041|5066|5067|5090|6277|6363)/.test(val)) {
                bandeira = 'Elo';
                img = 'https://logodownload.org/wp-content/uploads/2016/10/elo-logo-1.png';
            } else if (/^(606282|3841)/.test(val)) {
                bandeira = 'Hipercard';
                img = 'https://logodownload.org/wp-content/uploads/2016/10/hipercard-logo-3.png';
            } else if (/^3(?:6|8)/.test(val)) {
                bandeira = 'Diners Club';
                img = 'https://logodownload.org/wp-content/uploads/2017/04/diners-club-logo-1.png';
            } else {
                bandeira = '';
                img = '';
            }
            if (bandeira) {
                bandeiraDiv.innerHTML = `<img src="${img}" alt="${bandeira}" style="height:24px;vertical-align:middle;"> <span style="font-size:1em;color:#222;">${bandeira}</span>`;
            } else {
                bandeiraDiv.innerHTML = '';
            }
        });

        // Validação simples do cartão
        formPagamento.addEventListener('submit', function(e) {
            e.preventDefault();
            const metodo = formPagamento.pagamento.value;
            // Mostra mensagem de verificação
            pagamentoSucesso.style.display = 'block';

            // Timer de 2 segundos antes de redirecionar
            setTimeout(function() {
                if (metodo === 'pix') {
                    window.location.href = "../../PAGAMENTO/pagamento_conclu.html";
                    return;
                }
                // Validação básica cartão
                const numero = numeroCartao.value.replace(/\D/g, '');
                const nome = document.getElementById('nome-cartao').value.trim();
                const validade = document.getElementById('validade-cartao').value.trim();
                const cvv = document.getElementById('cvv-cartao').value.trim();

                if (numero.length < 13 || numero.length > 19) {
                    alert('Número do cartão inválido.');
                    numeroCartao.focus();
                    pagamentoSucesso.style.display = 'none';
                    return;
                }
                if (!nome) {
                    alert('Digite o nome impresso no cartão.');
                    document.getElementById('nome-cartao').focus();
                    pagamentoSucesso.style.display = 'none';
                    return;
                }
                if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(validade)) {
                    alert('Validade inválida. Use MM/AA.');
                    document.getElementById('validade-cartao').focus();
                    pagamentoSucesso.style.display = 'none';
                    return;
                }
                if (!/^\d{3,4}$/.test(cvv)) {
                    alert('CVV inválido.');
                    document.getElementById('cvv-cartao').focus();
                    pagamentoSucesso.style.display = 'none';
                    return;
                }
                // Redireciona para a página de pagamento concluído
                window.location.href = "../../PAGAMENTO/pagamento_conclu.html";
            }, 2000);
        });

        // Formatação automática do campo validade (MM/AA)
        const validadeInput = document.getElementById('validade-cartao');
        validadeInput.addEventListener('input', function(e) {
            let val = validadeInput.value.replace(/\D/g, '');

            // Limita o mês para 12
            if (val.length >= 1) {
                if (parseInt(val[0]) > 1) val = '0' + val[0];
            }
            if (val.length >= 2) {
                let mes = parseInt(val.slice(0, 2));
                if (mes === 0) mes = 1;
                if (mes > 12) mes = 12;
                val = mes.toString().padStart(2, '0') + val.slice(2);
            }

            // Adiciona a barra automaticamente
            if (val.length > 2) {
                val = val.slice(0, 2) + '/' + val.slice(2, 4);
            }
            validadeInput.value = val.slice(0, 5);
        });

        // Inicializa carrinho
        renderCarrinho();
    </script>
</body>
</html>