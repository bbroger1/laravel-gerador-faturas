# Gerador de Faturas

**GeradorFaturas** é uma biblioteca desenvolvida para gerar faturas personalizadas em PDF e enviá-las por e-mail utilizando o **Dompdf** e o **Laravel Mail**.

## Instalação

Primeiro, adicione a biblioteca ao seu projeto utilizando o `composer`:

```bash
composer require matondo/gerador-faturas

## Publicação dos Arquivos

Após a instalação, é necessário publicar os arquivos de visualização da fatura:

```bash
php artisan vendor:publish --provider="Matondo\MatondoServiceProvider"

Isso criará os arquivos de template da fatura que você poderá customizar.

## Registro do Service Provider

Certifique-se de registrar o MatondoServiceProvider no seu arquivo config/app.php, na seção providers:


'providers' => [
    // Outros providers
    Matondo\MatondoServiceProvider::class,
],


Exemplo de Uso

Aqui está um exemplo de como usar a biblioteca para gerar e enviar uma fatura por e-mail.


use Illuminate\Support\Facades\Route;
use Matondo\GeradorFaturas;

Route::get('/', function () {
    $dados = [
        'titulo' => 'Fatura Completa',
        'numero_fatura' => '111',
        'data' => '2024-09-25',
        'data_vencimento' => '2024-10-01',
        'moeda' => 'R$',
        'logo' => 'https://www.popdata.com.br/wp-content/uploads/2024/06/logo.png',
        'empresa' => [
            'nome' => 'PopData Software',
            'endereco' => 'Rua Exemplo, 123, São Paulo, SP',
            'email' => 'contato@popdata.com.br',
            'telefone' => '(11) 98765-4321',
        ],
        'cliente' => [
            'nome' => 'Cliente Exemplo',
            'endereco' => 'Rua Cliente, 456, São Paulo, SP',
            'email' => 'matondojoaokitemoco@gmail.com',
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

    return $fatura->download(123, true); // Gera a fatura, salva e envia por e-mail.
});

Parâmetros

dados: Array contendo as informações da fatura, empresa e cliente.
numeroDaFatura: Número da fatura gerada.
enviarPorEmail: Defina como true para enviar automaticamente a fatura por e-mail.

Funcionalidades

Geração de PDF: Gera uma fatura em PDF personalizada com os dados fornecidos.
Envio por E-mail: Envia a fatura gerada para o e-mail do cliente especificado.
Download de Fatura: Permite baixar a fatura diretamente no navegador.

Como Funciona

Renderização da Fatura: Os dados fornecidos são usados para preencher um template HTML de fatura.

Geração de PDF: O HTML é convertido para PDF usando o Dompdf.

Armazenamento: O PDF gerado é salvo em storage/public/faturas.

Envio por E-mail: A fatura é enviada para o cliente por e-mail utilizando a classe FaturaMail.

Download: O PDF gerado pode ser baixado diretamente.

Personalização

Os templates de fatura podem ser encontrados no diretório publicado após o comando php artisan vendor:publish. Você pode modificá-los para atender às necessidades da sua empresa ou projeto.

Licença

Este projeto está licenciado sob a licença MIT. Veja o arquivo LICENSE para mais detalhes.