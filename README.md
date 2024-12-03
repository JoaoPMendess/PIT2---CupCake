# Cupcake Store

## Descrição
O **Cupcake Store** é um site para gerenciamento e venda de cupcakes, desenvolvido como parte do PIT 2. Ele permite que usuários visualizem produtos, adicionem ao carrinho e finalizem suas compras de forma prática e eficiente.

## Objetivo
Criar uma aplicação web funcional para gerenciar produtos e oferecer aos usuários uma experiência simples e intuitiva de navegação e compra.

## Funcionalidades
- Exibição de cupcakes em formato de cards, com informações como nome, preço e quantidade disponível.
- **Carrinho de compras interativo**, atualizado em tempo real:
  - Adicionar, remover ou ajustar a quantidade de produtos.
  - Exibição do resumo do carrinho em um dropdown na barra de navegação.
  - Cálculo do total automaticamente.
- Layout responsivo utilizando **Bootstrap 5**.

## Tecnologias Utilizadas
- **HTML5** e **CSS3** para estrutura e estilo.
- **Bootstrap 5** para layout responsivo.
- **jQuery** para manipulação de DOM e requisições AJAX.
- **PHP** para o backend.
- **MySQL** para o banco de dados.

## Segurança de Senhas
O sistema utiliza a função `password_hash()` do PHP para armazenar as senhas de maneira segura no banco de dados. Isso garante que as senhas não sejam armazenadas em texto simples, mas sim como um hash seguro.

### Armazenamento de Senha
- Ao cadastrar um usuário, a senha é passada pela função `password_hash()` com **PASSWORD_BCRYPT** e **cost 12**, que a transforma em um hash único e irrecuperável. Esse hash é então armazenado no banco de dados.

## Estrutura de Diretórios

```plaintext
/
├── adm/               # Páginas dedicadas para parte administrativa
│   ├── inicio.php     # Exibe o dashboard com resultados de vendas
│   ├── pedidos.php    # Painel para realizar baixa e visualizar pedidos
│   ├── usuario.php    # Painel para adicionar permissão administrativa para um usuário
│   └── vitrine.php    # Painel para cadastrar e alterar cupcakes
├── css/               # Arquivos de estilos
│   ├── adm.css        # Estilos dedicados à página administrativa
│   ├── bootstrap.css  # Estilos básicos do Bootstrap
│   ├── datatables.css # Estilos para tabela de dados (DataTables)
│   ├── sb-admin.css   # Estilos de gráfico para o painel administrativo
│   └── style.css      # Estilos personalizados do projeto
├── js/                # Scripts (JavaScript/jQuery)
│   ├── bootstrap.bundle.min.js # Scripts básicos do Bootstrap
│   ├── chart-area-demo.js      # Inicializador de gráfico tipo área
│   ├── chart-pie-demo.js       # Inicializador de gráfico tipo pizza
│   ├── Chart.min.js            # Biblioteca de gráficos (Chart.js)
│   └── custom.js         # Scripts personalizados do site (ex: carrinho, interações)
├── imgens/            # Imagens utilizadas no site
│   └── vitrine/       # Imagens dos cupcakes
├── include/           # Funções, classes e páginas adicionais em PHP para o backend
│   ├── db.php          # Classe para conexão com o banco de dados MySQL
│   ├── menu.php        # Inclusão do menu para a página index.php
│   ├── system.func.php # Funções adicionais do sistema (ex: manipulação de dados)
│   └── vitrine.php     # Exibição de produtos para o cliente
├── adm.php            # Página inicial para operações administrativas
├── jax.php            # Responsável por requisições AJAX
├── index.php          # Página inicial do site (frontend)
└── README.md          # Documentação do projeto
```


Como Executar o Projeto
Clone o repositório do GitHub:
git clone https://github.com/seuusuario/cupcake-store.git
Configure o ambiente:
Certifique-se de ter PHP e MySQL instalados.
Crie um banco de dados no MySQL e importe o arquivo projetopit.sql.
Atualize as configurações de conexão no arquivo db.php (localizado na pasta include/).
Inicie um servidor local:
Acesse o projeto via navegador: http://localhost/cupcake-store.
Pronto! O site estará funcionando.

usuário administrativo.
Usuário: admin
Email: admin@admin.com
Senha: senha123


## Importante: Aviso sobre Uso em Produção

Este projeto é de uso acadêmico e **não deve ser utilizado em ambientes de produção**. O objetivo principal deste sistema é demonstrar os conceitos de desenvolvimento de sistemas web, como manipulação de formulários, armazenamento em banco de dados e autenticação de usuários.

---

## Limitações de Segurança

Embora o sistema utilize boas práticas básicas, como o uso de `password_hash()` para armazenamento seguro de senhas, ele não está totalmente preparado para uso em produção. Algumas áreas que necessitam de melhorias incluem:

- **Validação de Dados:** A validação de dados fornecidos pelo usuário deve ser mais rigorosa para evitar ataques de injeção de SQL, XSS e outras vulnerabilidades.
- **Comparação de Tokens de Sessão:** O uso de tokens para autenticação e prevenção de CSRF (Cross-Site Request Forgery) não foi implementado, o que é essencial para garantir a segurança das interações entre o cliente e o servidor.
- **Criptografia:** Embora as senhas sejam armazenadas de forma segura, outras informações sensíveis podem precisar de criptografia adicional.
- **Controle de Acesso:** A verificação de permissões de usuários deve ser mais robusta, garantindo que um usuário não possa acessar áreas que não são autorizadas para ele.

---

## Ajustes Necessários para Produção

Se você planeja utilizar esse sistema em um ambiente de produção, considere realizar os seguintes ajustes:

- **Validação e Sanitização de Entrada:** Implemente validações mais completas nos dados inseridos pelo usuário para proteger contra SQL Injection e XSS.
- **Proteção Contra CSRF:** Adicione proteção contra ataques CSRF, implementando tokens para todas as requisições sensíveis.
- **Controle de Sessões e Tokens:** Melhore o controle de sessões e utilize tokens para garantir que a autenticação seja feita de maneira mais segura.
- **Criptografia de Dados Sensíveis:** Avalie a necessidade de criptografar dados sensíveis além das senhas (por exemplo, dados de pagamento, se for o caso).
- **Testes de Segurança:** Realize testes de segurança, como testes de penetração, para identificar possíveis vulnerabilidades.

Este projeto **não deve ser utilizado para fins comerciais** ou em ambientes onde a segurança seja uma preocupação crítica, sem antes realizar essas melhorias.

---

## Por que essa Limitação?

O objetivo deste sistema é servir como uma base de aprendizado. Algumas boas práticas de segurança, como autenticação robusta, validação de entrada, e proteção contra CSRF, foram simplificadas ou não implementadas para fins didáticos. Antes de usar esse sistema em produção, é fundamental revisar as questões de segurança e realizar os ajustes necessários.

