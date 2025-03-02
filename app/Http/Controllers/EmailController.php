<?php

namespace App\Http\Controllers;

use App\Mail\SolicitacaoEmail;
use App\Models\EmailModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function index()
    {
        $emails = EmailModel::orderByDesc('created_at')->get();

        return view('email.inbox', [
            'title'=> 'Emails',
            'emails'=> $emails,
        ]);
    }

    public function compose()
    {
        $emails = EmailModel::all();

        return view('email.compose', [
            'title' => 'Emails | Criando',
        ]);
    }
    public function read($id)
    {
        $emails= EmailModel::where('id', $id)->first();
        
        //dd($emails);
        return view('email.read', [
            'title'=> "Email nº $id | 2ACONT ",
            'de'=> $emails->de,
            'para'=> $emails->para,
            'assunto'=> $emails->assunto,
            'copia'=> $emails->copia,
            'recebido_em'=> $emails->created_at,
            'corpo_email'=> $emails->corpo_email,

         ]);
    }
    public function send(Request $request)
    {
        
        DB::beginTransaction();
        
        try {

           $email_solicitacao = EmailModel::where('id',$request->input('id') )->first();

           //dd(!$email_solicitacao);
            if(!$email_solicitacao){

                //dd($request->input('cliente_id'));
                $novo = EmailModel::create([
                    'de'         => $request->input('de'),
                    'para'       => $request->input('para'),
                    'copia'      => $request->input('copia') ?? '',
                    'assunto'    => $request->input('assunto'),
                    'label'      => $request->input('label') ?? '',
                    'marcadores' => $request->input('marcadores') ?? '',
                    'corpo_email'=> $request->input('corpo_email'),
                    'cliente_id' => $request->input('cliente_id'),
                ]);
                //dd($novo);
                DB::commit();

                $id_email = $novo->id;
                //dd($id_email);


                $email_solicitacao = EmailModel::where('id', $id_email )->first();


                Mail::to(env('MAIL_TO'))->send(new SolicitacaoEmail($email_solicitacao));

                Log::info("Email enviado para $novo->para com sucesso, registrado sob o número $novo->id !" );

                return redirect()->route('email.index')->with('success', "Email enviado para $novo->para com sucesso, registrado sob o número $novo->id !");

            }else{

                DB::rollBack();

                Log::warning('Email não enviado_verifique os dados com o Administrador');

                return back()->with('error', 'Email não enviado -1 ');

            }


           

        } catch (Exception $e) {

            DB::rollBack();

            Log::warning('Email não enviado', ['error' => $e->getMessage()]);

            return back()->with('error', 'Email não enviado - 2');
        }
    }
}
