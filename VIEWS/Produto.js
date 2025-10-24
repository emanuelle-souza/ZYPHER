// // Produto.js
// document.addEventListener('DOMContentLoaded', function () {
//     const tamanhoBtns = document.querySelectorAll('.size-btn');
//     const addBtn = document.getElementById('add-carrinho');
//     const produtoData = document.getElementById('produto-data');

//     if (!produtoData) {
//         console.error('Dados do produto não encontrados no HTML.');
//         return;
//     }

//     const PROD_ID = parseInt(produtoData.dataset.id || '0', 10);
//     const PROD_NOME = produtoData.dataset.nome || '';
//     const PROD_PRECO = parseFloat(produtoData.dataset.preco || '0');
//     const PROD_IMAGEM = produtoData.dataset.imagem || '';

//     // Gerencia seleção visual do tamanho
//     let tamanhoSelecionado = null;
//     tamanhoBtns.forEach(btn => {
//         btn.addEventListener('click', function () {
//             tamanhoBtns.forEach(b => b.classList.remove('active'));
//             this.classList.add('active');
//             tamanhoSelecionado = this.dataset.size;
//         });
//     });

//     // Função utilitária para carregar carrinho do localStorage
//     function carregarCarrinho() {
//         try {
//             return JSON.parse(localStorage.getItem('carrinho')) || [];
//         } catch (e) {
//             return [];
//         }
//     }

//     // Salvar carrinho
//     function salvarCarrinho(carrinho) {
//         localStorage.setItem('carrinho', JSON.stringify(carrinho));
//     }

//     // Ao clicar em adicionar ao carrinho
//     addBtn.addEventListener('click', function (e) {
//         e.preventDefault();

//         if (!tamanhoSelecionado) {
//             alert('Selecione um tamanho antes de adicionar ao carrinho.');
//             return;
//         }

//         // Carrega carrinho
//         const carrinho = carregarCarrinho();

//         // Verifica se produto + tamanho já existe
//         const existenteIndex = carrinho.findIndex(item => 
//             parseInt(item.id, 10) === PROD_ID && String(item.tamanho) === String(tamanhoSelecionado)
//         );

//         if (existenteIndex > -1) {
//             // Incrementa quantidade
//             carrinho[existenteIndex].qtd = (carrinho[existenteIndex].qtd || 1) + 1;
//         } else {
//             // Adiciona novo item
//             carrinho.push({
//                 id: PROD_ID,
//                 nome: PROD_NOME,
//                 preco: PROD_PRECO,
//                 imagem: PROD_IMAGEM,
//                 tamanho: tamanhoSelecionado,
//                 qtd: 1
//             });
//         }

//         salvarCarrinho(carrinho);

//         // Confirmação
//         if (confirm('Produto adicionado ao carrinho! Deseja ir para o carrinho agora?')) {
//             window.location.href = '/zypher/views/CarrinhoCliente.php';
//         } else {
//             // opcional: animação ou feedback visual
//             addBtn.textContent = 'ADICIONADO ✓';
//             setTimeout(() => addBtn.textContent = 'ADICIONAR AO CARRINHO', 2000);
//         }
//     });
// });
