# Gerador de Faturas

GeradorFaturas é uma biblioteca desenvolvida para gerar faturas personalizadas em PDF e enviá-las por e-mail utilizando o Dompdf e o Laravel Mail.

# Instalação

Para instalar a biblioteca, utilize o composer:

```php
composer require matondo/gerador-faturas
```

# Registro do Service Provider

Certifique-se de registrar o MatondoServiceProvider no arquivo config/app.php, na seção providers:


```php
'providers' => [
    // Outros providers
    Matondo\MatondoServiceProvider::class,
],

```

# Publicação dos Arquivos

Após a registrar o MatondoServiceProvider, publique os arquivos de visualização da fatura:


```php
php artisan vendor:publish --provider="Matondo\MatondoServiceProvider"
```
Esse comando criará os arquivos de template da fatura que poderão ser customizados conforme necessário.

# Exemplo de Uso

Aqui está um exemplo de como utilizar a biblioteca para gerar e enviar uma fatura por e-mail:


```php
use Illuminate\Support\Facades\Route;
use Matondo\GeradorFaturas;

Route::get('/', function () {
    $dados = [
        'titulo' => 'Fatura Completa',
        'numero_fatura' => '111',
        'data' => '2024-09-25',
        'data_vencimento' => '2024-10-01',
        'moeda' => 'R$',
        'logo' => 'https://www.empresa.com/wp-content/uploads/2024/06/logo.png',
        'empresa' => [
            'nome' => 'Empresa Software',
            'endereco' => 'Rua Exemplo, 123, São Paulo, SP',
            'email' => 'contato@empresa.com.br',
            'telefone' => '(11) 98765-4321',
        ],
        'cliente' => [
            'nome' => 'Cliente Exemplo',
            'endereco' => 'Rua Cliente, 456, São Paulo, SP',
            'email' => 'cliente@example.com',
            'telefone' => '(11) 91234-5678',
        ],
        'itens' => [
            ['nome' => 'Produto 1', 'quantidade' => 2, 'preco_unitario' => 100.00, 'desconto' => 10.00],
            ['nome' => 'Produto 2', 'quantidade' => 1, 'preco_unitario' => 50.00, 'desconto' => 5.00],
        ],
        'total' => 235.00,
        'situacao' => 'Pedido Recebido',
    ];

    $fatura = new GeradorFaturas($dados);

    return $fatura->download($dados['numero_fatura'], true); // Gera a fatura, salva e envia por e-mail.
});

```

# Parâmetros

- **dados**: Array contendo as informações da fatura, empresa e cliente.
- **numeroDaFatura**: Número da fatura gerada.
- **enviarPorEmail**: Defina como true para enviar automaticamente a fatura por e-mail.

# Funcionalidades

- **Geração de PDF**: Cria uma fatura em PDF personalizada com os dados fornecidos.
- **Envio por E-mail**: Envia a fatura gerada para o e-mail do cliente especificado.
- **Download de Fatura**: Permite baixar a fatura diretamente no navegador.

# Como Funciona

- **Renderização da Fatura**: Os dados fornecidos são utilizados para preencher um template HTML de fatura.
- **Geração de PDF:** O HTML gerado é convertido para PDF utilizando o Dompdf.
- **Armazenamento:** O PDF gerado é salvo no diretório storage/public/faturas.
- **Envio por E-mail:** A fatura é enviada para o cliente por e-mail utilizando a classe FaturaMail.
- **Download**: O PDF gerado pode ser baixado diretamente no navegador.

# Personalização

Os templates de fatura podem ser encontrados no diretório publicado após a execução do comando:


```php
php artisan vendor:publish
```

Você pode modificá-los para atender às necessidades da sua empresa ou projeto.

# Licença

Este projeto está licenciado sob a licença MIT. Veja o arquivo LICENSE para mais detalhes.

