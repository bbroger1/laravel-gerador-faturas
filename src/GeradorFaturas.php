<?php

namespace Matondo;

use Dompdf\Dompdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;
use Matondo\Mail\FaturaMail;
use Illuminate\Support\Facades\Mail;

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

    public function salvar($numeroDaFatura)
    {
        $output = $this->gerar();

        $timestamp = now()->timestamp;
        $nomeArquivo = "fatura3{$numeroDaFatura}-{$timestamp}.pdf"; 

        if (!Storage::exists('public/faturas')) {
            Storage::makeDirectory('public/faturas');
        }

        Storage::put("public/faturas/{$nomeArquivo}", $output);

        return $nomeArquivo;
    }

    protected function renderizarFatura()
    {
        return View::make('matondo::fatura', $this->dados)->render();
    }

    public function download($numeroDaFatura, $enviarPorEmail = false)
    {
        $nomeArquivo = $this->salvar($numeroDaFatura); 
        
        if ($enviarPorEmail) {
            $this->enviarFaturaPorEmail($nomeArquivo);
        }

        return response()->download(storage_path("app/public/faturas/{$nomeArquivo}")); 
    }

    protected function enviarFaturaPorEmail($nomeArquivo)
    {
        $emailDestinatario = $this->dados['cliente']['email'];
        Mail::to($emailDestinatario)->send(new FaturaMail($this->dados, $nomeArquivo));
    }

}

