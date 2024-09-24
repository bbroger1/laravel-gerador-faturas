<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>{{ $titulo }}</title>
    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="{{ $logo }}" alt="Logo Empresa" style="width:100%; max-width: 300px;">
                            </td>
                            <td>
                                {{ $titulo }} #: {{ $numero_fatura }}<br>
                                Data: {{ $data }}<br>
                                Vencimento: {{ $data_vencimento }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                {{ $empresa['nome'] }}<br>
                                {{ $empresa['endereco'] }}<br>
                                Email: {{ $empresa['email'] }}<br>
                                Telefone: {{ $empresa['telefone'] }}
                            </td>
                            <td>
                                {{ $cliente['nome'] }}<br>
                                Endereço: {{ $cliente['endereco'] }}<br>
                                Email: {{ $cliente['email'] }}<br>
                                Telefone: {{ $cliente['telefone'] }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Item</td>
                <td>Preço</td>
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
                <td></td>
                <td>Total: {{ $moeda }} {{ number_format($total, 2, ',', '.') }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
