<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use App\Contato;

class NovoContato extends Mailable
{
    use Queueable, SerializesModels;

    public $contato;

    public function __construct(Contato $contato)
    {
        $this->contato = $contato;
    }

    public function build()
    {
        return $this->view('emails.novocontato')
            ->subject("Novo contato")
            ->attachFromStorage($this->contato->path);
    }
}
