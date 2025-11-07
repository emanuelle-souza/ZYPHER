<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Termos de Uso - Zypher Sneakers</title>
  <link rel="stylesheet" href="/zypher/CSS/TermosDeUso.css" />
</head>
<body>
     <header>
        <div class="topo">
            <div class="logo">
                <a href="/zypher/VIEWS/HomeCliente.php">
                    <img src="/zypher/MIDIA/LogoDeitado.png" alt="Zypher Sneakers" class="logo-img">
                </a>
            </div>
            <div class="busca">
                <input type="text" placeholder="Buscar...">
                <button>🔍</button>
            </div>
            <div class="icones">
                <a href="/zypher/views/SejaMembro.php"><img src="/zypher/MIDIA/coroa.png" alt="coroa"></a>
                <a href="/zypher/views/Carrinho.php"><img src="/zypher/MIDIA/carrinho.png" alt="carrinho"></a>
                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <a href="/zypher/views/PerfilUsuario.php" title="Meu Perfil">
                        <img src="/zypher/MIDIA/perfil.png" alt="perfil">
                    </a>
                <?php else: ?>
                    <a href="/zypher/views/login.php" title="Entrar">
                        <img src="/zypher/MIDIA/perfil.png" alt="Entrar">
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!--CONTEÚDO PRINCIPAL-->
    <section class="termos">
        <h1>TERMOS DE USO</h1>
        <p>
          <strong>TERMOS DE USO – ZYPHER SNEAKERS</strong><br><br>
          
          <strong>1. Disposições Gerais</strong><br>
          O presente Termo de Uso regula as condições gerais para utilização do site ZYPHER SNEAKERS (doravante denominado "Site"), de propriedade de ZYPHER SNEAKERS LTDA, pessoa jurídica de direito privado, inscrita no CNPJ sob nº [inserir CNPJ], com sede em [inserir endereço completo].<br>
          Ao acessar ou utilizar o Site, o Usuário declara ter lido, compreendido e aceitado integralmente os presentes Termos de Uso e todas as demais políticas aplicáveis.<br><br>
          
          <strong>2. Cadastro e Responsabilidade do Usuário</strong><br>
          2.1. Para efetuar compras, o Usuário deverá realizar um cadastro, fornecendo informações verdadeiras, completas e atualizadas.<br>
          2.2. O Usuário é o único responsável pela veracidade dos dados informados e pela confidencialidade de seu login e senha.<br>
          2.3. A ZYPHER SNEAKERS não se responsabiliza por danos decorrentes de uso indevido da conta do Usuário por terceiros.<br><br>
          
          <strong>3. Privacidade e Proteção de Dados</strong><br>
          3.1. Os dados pessoais coletados são tratados de acordo com a Lei nº 13.709/2018 (Lei Geral de Proteção de Dados – LGPD).<br>
          3.2. As informações dos Usuários são utilizadas exclusivamente para fins de cadastro, processamento de pedidos, entrega de produtos e comunicações relacionadas às compras.<br>
          3.3. Para mais informações, o Usuário deverá consultar a Política de Privacidade, disponível no Site.<br><br>
          
          <strong>4. Produtos, Preços e Pagamentos</strong><br>
          4.1. Todos os produtos exibidos no Site estão sujeitos à disponibilidade de estoque.<br>
          4.2. Os preços e condições de pagamento podem ser alterados a qualquer momento, sem aviso prévio, prevalecendo aqueles vigentes no momento da finalização do pedido.<br>
          4.3. A confirmação do pedido está condicionada à aprovação do pagamento pela instituição financeira ou operadora de cartão de crédito.<br>
          4.4. Em caso de suspeita de fraude ou irregularidade na transação, a ZYPHER SNEAKERS reserva-se o direito de cancelar o pedido.<br><br>
          
          <strong>5. Entrega dos Produtos</strong><br>
          5.1. O prazo de entrega informado no Site é apenas uma estimativa e pode variar conforme a localidade e a modalidade de envio escolhida.<br>
          5.2. A ZYPHER SNEAKERS não se responsabiliza por atrasos ocasionados por terceiros, como transportadoras ou serviços dos Correios.<br>
          5.3. A entrega será realizada no endereço indicado pelo Usuário no momento da compra, sendo indispensável a presença de pessoa autorizada para recebimento.<br><br>
          
          <strong>6. Trocas, Devoluções e Arrependimento</strong><br>
          6.1. O Usuário poderá solicitar a troca ou devolução de produtos conforme as disposições do Código de Defesa do Consumidor (Lei nº 8.078/1990).<br>
          6.2. O produto deverá ser devolvido sem indícios de uso, acompanhado da embalagem original, etiquetas e nota fiscal.<br>
          6.3. O prazo para arrependimento da compra é de 07 (sete) dias corridos a contar do recebimento do produto, conforme o art. 49 do CDC.<br><br>
          
          <strong>7. Direitos de Propriedade Intelectual</strong><br>
          7.1. Todo o conteúdo do Site, incluindo textos, imagens, logotipos, marcas, ícones, layouts, vídeos e demais materiais, constitui propriedade intelectual exclusiva da ZYPHER SNEAKERS ou de seus parceiros comerciais.<br>
          7.2. É expressamente proibida a reprodução, distribuição, exibição ou modificação, total ou parcial, de qualquer conteúdo sem autorização prévia e por escrito da empresa.<br><br>
          
          <strong>8. Limitação de Responsabilidade</strong><br>
          8.1. A ZYPHER SNEAKERS não se responsabiliza por danos diretos ou indiretos decorrentes da utilização indevida do Site ou de seus serviços.<br>
          8.2. O Usuário reconhece que o acesso à Internet está sujeito a interrupções e falhas, não sendo a empresa responsável por indisponibilidades temporárias.<br><br>
          
          <strong>9. Alterações dos Termos de Uso</strong><br>
          9.1. A ZYPHER SNEAKERS poderá, a qualquer momento e sem aviso prévio, modificar, revisar ou atualizar os presentes Termos de Uso.<br>
          9.2. As alterações entrarão em vigor imediatamente após sua publicação no Site.<br><br>
          
          <strong>10. Legislação Aplicável e Foro</strong><br>
          10.1. Estes Termos de Uso são regidos pelas leis da República Federativa do Brasil.<br>
          10.2. Fica eleito o foro da comarca de [inserir cidade e estado da sede da empresa], com renúncia a qualquer outro, por mais privilegiado que seja, para dirimir quaisquer controvérsias decorrentes do presente documento.
        </p>
      </section>

         <!--RODAPÉ-->
 <footer>
    <a href="/zypher/VIEWS/Politicas.php">Política de Privacidade</a> | 
    <a href="/zypher/VIEWS/TermosDeUso.php">Termos de Uso</a> | 
    <a href="/zypher/VIEWS/FaleConosco.php">Fale conosco</a>
    <p>&copy; 2025 Zypher Sneakers. Todos os direitos reservados.</p>
</footer>
</body>
</html>