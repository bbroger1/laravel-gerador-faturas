<?php

namespace Matondo\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FaturaMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $dados;
    public $nomeArquivo;

    /**
     * Create a new message instance.
     *
     * @param array $dados
     * @param string $nomeArquivo
     * @return void
     */
    public function __construct(array $dados, $nomeArquivo)
    {
        $this->dados = $dados;
        $this->nomeArquivo = $nomeArquivo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('matondo::emails.fatura')
                    ->subject('Assunto do E-mail: Fatura ' . $this->dados['numero_fatura'])
                    ->attach(storage_path("app/public/faturas/{$this->nomeArquivo}"))
                    ->with('dados', $this->dados);
    }
}

