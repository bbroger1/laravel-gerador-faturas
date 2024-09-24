<?php

namespace Matondo\GeradorFaturas;

use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;
use Matondo\GeradorFaturas\FaturaTemplate;

class GeradorFaturas
{
    protected $dados;
    
    public function __construct($dados)
    {
        $this->dados = $dados;
    }

    public function gerar()
    {
        $html = $this->renderizarFatura();

        $pdf = new Dompdf();
        $pdf->loadHtml($html);
        $pdf->set_option('isRemoteEnabled', true); 
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        return $pdf->output();
    }

    public function salvar($caminhoArquivo)
    {
        $output = $this->gerar();
        file_put_contents($caminhoArquivo, $output);
    }

    protected function renderizarFatura()
    {
        $template = new FaturaTemplate($this->dados);
        return $template->renderizar();
    }
}
