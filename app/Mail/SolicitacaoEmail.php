<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;

class SolicitacaoEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

     public $email_solicitacao;
     public $file;
     public $extension;

    public function __construct($email_solicitacao, $file, $extension)
    {
        $this->email_solicitacao = $email_solicitacao;
        $this->file = $file;
        $this->extension = $extension;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Solicitação Email'.date('dmY-H:i:s'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.modelo_email',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
    public function build() // apenas  1 anexo
    {
        $data = date('Y-m-d_H-I-s');

        return $this->view('email.compose')
            ->with('email_solicitacao', $this->email_solicitacao)
            ->subject('Socilicatação nº: ' . $this->email_solicitacao->id)
            ->attachData(file_get_contents($this->file), 'Anexo-'.$data.$this->email_solicitacao->name .'.'.$this->extension, [
            //'mime' => 'application/pdf',
            ]);
    }

    // public function build()
    // {
    //     $email = $this->view('email.compose')
    //         ->with('email_solicitacao', $this->email_solicitacao)
    //         ->subject('Solicitação nº: ' . $this->email_solicitacao->id);

    //     // Verifica se há anexos
    //     if (!empty($this->file)) {
    //         // Se for um único arquivo, transforma em array para padronizar o loop
    //         $files = is_array($this->file) ? $this->file : [$this->file];

    //         // Percorre e anexa cada arquivo
    //         foreach ($files as $file) {
    //             if ($file instanceof \Illuminate\Http\UploadedFile) {
    //                 $email->attachData(
    //                     file_get_contents($file->getRealPath()), // Obtém o conteúdo do arquivo
    //                     'Anexo-' . $this->email_solicitacao->name . '.' . $file->getClientOriginalExtension(), // Nome com extensão original
    //                     ['mime' => $file->getMimeType()] // Obtém o MIME correto
    //                 );
    //             }
    //         }
    //     }

    //     return $email;
    // }



}
