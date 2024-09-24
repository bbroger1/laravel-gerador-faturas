<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <title>{{ $titulo }}</title>
    <style>
        body {
            font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
            color: #555;
            margin: 0;
            padding: 0;
        }
        .invoice-box {
            max-width: 700px;
            margin: auto;
            padding: 20px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            font-size: 14px;
            line-height: 20px;
            background-color: #fff;
        }
        .title img {
            width: 150px; /* Tamanho ajustado para 150px */
            height: auto;
            display: block;
            margin: 0 auto 20px; /* Centraliza a logo com espaçamento em baixo */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0; /* Espaçamento superior e inferior */
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2; /* Cor de fundo para o cabeçalho */
            font-weight: bold;
        }
        .total {
            font-weight: bold;
            background-color: #f9f9f9; /* Cor de fundo para a linha total */
        }
        .header, .footer {
            text-align: center;
            padding: 10px;
            font-size: 18px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="header">
            <img src="{{ $logo }}" alt="Logo Empresa" class="title" width="200px">
            <h1>{{ $titulo }}</h1>
            <p>Fatura #: {{ $numero_fatura }}</p>
            <p>Data: {{ $data }} | Vencimento: {{ $data_vencimento }}</p>
            <p>Situação: {{ $situacao }}</p> 
        </div>
        <table class="information">
            <tr>
                <td>
                    <strong>{{ $empresa['nome'] }}</strong><br>
                    {{ $empresa['endereco'] }}<br>
                    Email: {{ $empresa['email'] }}<br>
                    Telefone: {{ $empresa['telefone'] }}
                </td>
                <td>
                    <strong>{{ $cliente['nome'] }}</strong><br>
                    Endereço: {{ $cliente['endereco'] }}<br>
                    Email: {{ $cliente['email'] }}<br>
                    Telefone: {{ $cliente['telefone'] }}
                </td>
            </tr>
        </table>
        <table class="items">
            <tr class="heading">
                <th>Item</th>
                <th>Preço</th>
            </tr>
            @foreach ($itens as $item)
                <tr class="item">
                    <td>
                        {{ $item['nome'] }} <br>
                        Quantidade: {{ $item['quantidade'] }} x {{ $moeda }} {{ number_format($item['preco_unitario'], 2, ',', '.') }} <br>
                        Desconto: {{ $moeda }} {{ number_format($item['desconto'], 2, ',', '.') }}
                    </td>
                    <td>{{ $moeda }} {{ number_format(($item['preco_unitario'] * $item['quantidade']) - $item['desconto'], 2, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="total">
                <td>Total</td>
                <td>{{ $moeda }} {{ number_format($total, 2, ',', '.') }}</td>
            </tr>
        </table>
        <div class="footer">
            <p>Obrigado pela sua compra!</p>
        </div>
    </div>
</body>
</html>
