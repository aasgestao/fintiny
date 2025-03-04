<?php

namespace App\Http\Controllers;

use App\Mail\SolicitacaoEmail;
use App\Models\ArquivosModel;
use App\Models\EmailModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Webklex\IMAP\Facades\Client;

class EmailController extends Controller
{
    public function index()
    {
        $emails = EmailModel::orderByDesc('created_at')->paginate(6);
        
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
            'count' => $emails->count(),
        ]);
    }
    public function read($id)
    {
        $emails= EmailModel::where('id', $id)->first();
        $arquivos = ArquivosModel::where('email_id', $id)->get();
        
        //dd($emails);
        return view('email.read', [
            'title'=> "Email nº $id | 2ACONT ",
            'de'=> $emails->de,
            'para'=> $emails->para,
            'assunto'=> $emails->assunto,
            'copia'=> $emails->copia,
            'recebido_em'=> $emails->created_at,
            'corpo_email'=> $emails->corpo_email,
            'arquivos'=> $arquivos,

         ]);
    }
    public function send(Request $request)
    {

        $file = $request->file('anexo'); // Pega o arquivo do input
        //dd($file);
       

        if ($file && $file->isValid()) {
                $date = date('Ymd_His');
                $nome = 'Anexo_importado_';

                // Obtém a extensão original do arquivo
                $extension = $file->getClientOriginalExtension();
                //dd($extension);
                // Gera um nome único mantendo a extensão original
                $newFileName = "$nome$date.$extension";

                // Salva o arquivo em storage/app/uploads/
                $filePath = $file->storeAs('uploads', $newFileName);

                // Obtém o caminho completo do arquivo
                $fullPath = storage_path("app/uploads/$newFileName");

            //dd("Arquivo salvo em: " . $extension);
            
            };
                


            


        DB::beginTransaction();
        
        try {

           $email_solicitacao = EmailModel::where('id',$request->input('id') )->first();

           //dd(!$email_solicitacao, $request);
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
                $pathExiste = ArquivosModel::where('path', $newFileName)->first();

                if(!$pathExiste){
                        $arquivo= ArquivosModel::create([
                        'path'=> $newFileName,
                        'email_id' => $id_email,
                    ]);
                    Log::info("Arquivo salvo com sucesso, registrado sob o número $arquivo->id, vinculado ao emails $novo->id !");

                }

                


                $email_solicitacao = EmailModel::where('id', $id_email )->first();
                //dd($email_solicitacao);

                Mail::to(env('MAIL_TO'))->send(new SolicitacaoEmail($email_solicitacao, $file , $extension));

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

   

    public function receberEmails()
    {
        //dd("estou aqui");
        $client = Client::account('default'); // Pega as credenciais do .env
        //dd($client);
        
        $client->connect(); // Conecta no servidor de e-mail
        dd($client);
        $folder = $client->getFolder('INBOX'); // Lê a Caixa de Entrada
        dd($folder->messages()->unseen()->limit(10)->get());
        foreach ($folder->messages()->unseen()->limit(10)->get() as $email) {
            dd($email);
            echo "Assunto: " . $email->getSubject() . "<br>";
            echo "De: " . $email->getFrom()[0]->mail . "<br>";
            echo "Corpo: " . $email->getTextBody() . "<br>";
            echo "<hr>";


            dd($email);
            // Aqui você pode armazenar no banco
            // DB::table('emails')->insert([
            //     'remetente' => $email->getFrom()[0]->mail,
            //     'assunto' => $email->getSubject(),
            //     'corpo' => $email->getTextBody(),
            //     'recebido_em' => now(),
            // ]);

            //dd($request->input('cliente_id'));
            // $novo = EmailModel::create([
            //     'de' => $request->input('de'),
            //     'para' => $request->input('para'),
            //     'copia' => $request->input('copia') ?? '',
            //     'assunto' => $request->input('assunto'),
            //     'label' => $request->input('label') ?? '',
            //     'marcadores' => $request->input('marcadores') ?? '',
            //     'corpo_email' => $request->input('corpo_email'),
            //     'cliente_id' => $request->input('cliente_id'),
            // ]);
        }
    }


}
