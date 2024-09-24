<?php

namespace Matondo\GeradorFaturas;

use Illuminate\Support\Facades\Storage;

class FaturaTemplate
{
    protected $dados;

    public function __construct($dados)
    {
        $this->dados = $dados;
    }

    public function renderizar()
    {
        $titulo = isset($this->dados['titulo']) ? $this->dados['titulo'] : 'Fatura Detalhada';

        $numero_fatura = isset($this->dados['numero_fatura']) ? $this->dados['numero_fatura'] : '111';
        $timestamp = time();
        $nome_arquivo = "fatura#{$numero_fatura}-{$timestamp}.pdf";

        $moeda = isset($this->dados['moeda']) ? $this->dados['moeda'] : 'R$';

        $output = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8" />
            <title>' . $titulo . '</title>
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

                .invoice-box table {
                    width: 100%;
                    line-height: inherit;
                    text-align: left;
                }

                .invoice-box table td {
                    padding: 5px;
                    vertical-align: top;
                }

                .invoice-box table tr td:nth-child(2) {
                    text-align: right;
                }

                .invoice-box table tr.top table td {
                    padding-bottom: 20px;
                }

                .invoice-box table tr.top table td.title {
                    font-size: 45px;
                    line-height: 45px;
                    color: #333;
                }

                .invoice-box table tr.information table td {
                    padding-bottom: 40px;
                }

                .invoice-box table tr.heading td {
                    background: #eee;
                    border-bottom: 1px solid #ddd;
                    font-weight: bold;
                }

                .invoice-box table tr.item td {
                    border-bottom: 1px solid #eee;
                }

                .invoice-box table tr.total td:nth-child(2) {
                    border-top: 2px solid #eee;
                    font-weight: bold;
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
                                        <img src="' . $this->dados['logo'] . '" alt="Logo Empresa" style="width:100%; max-width: 300px;">
                                    </td>
                                    <td>
                                        ' . $titulo . ' #: ' . $numero_fatura . '<br>
                                        Data: ' . $this->dados['data'] . '<br>
                                        Vencimento: ' . $this->dados['data_vencimento'] . '
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
                                        ' . $this->dados['empresa']['nome'] . '<br>
                                        ' . $this->dados['empresa']['endereco'] . '<br>
                                        Email: ' . $this->dados['empresa']['email'] . '<br>
                                        Telefone: ' . $this->dados['empresa']['telefone'] . '
                                    </td>
                                    <td>
                                        ' . $this->dados['cliente']['nome'] . '<br>
                                        Endereço: ' . $this->dados['cliente']['endereco'] . '<br>
                                        Email: ' . $this->dados['cliente']['email'] . '<br>
                                        Telefone: ' . $this->dados['cliente']['telefone'] . '
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr class="heading">
                        <td>Item</td>
                        <td>Preço</td>
                    </tr>';

        foreach ($this->dados['itens'] as $item) {

            $preco_total_item = ($item['preco_unitario'] * $item['quantidade']) - $item['desconto'];
            $output .= '
                    <tr class="item">
                        <td>
                            ' . $item['nome'] . ' <br>
                            Quantidade: ' . $item['quantidade'] . ' x ' . $moeda . ' ' . number_format($item['preco_unitario'], 2, ',', '.') . ' <br>
                            Desconto: ' . $moeda . ' ' . number_format($item['desconto'], 2, ',', '.') . '
                        </td>
                        <td>' . $moeda . ' ' . number_format($preco_total_item, 2, ',', '.') . '</td>
                    </tr>';
        }

        $output .= '
                    <tr class="total">
                        <td></td>
                        <td>Total: ' . $moeda . ' ' . number_format($this->dados['total'], 2, ',', '.') . '</td>
                    </tr>
                </table>
            </div>
        </body>
        </html>';

        $this->criarDiretorioSeNaoExistir('public/faturas');

        Storage::put("public/faturas/{$nome_arquivo}", $output);

        return $nome_arquivo;
    }

    protected function criarDiretorioSeNaoExistir($path)
    {
        if (!Storage::exists($path)) {
            Storage::makeDirectory($path);
        }
    }
}
