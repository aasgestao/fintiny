<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Email - Mensagem - Automática </title>
</head>
<body>
    <header>
        <img src="{{ asset('img/logo2.png')}}" alt="logo" >

        <span>Resumo- Impressão Email {{ $email_solicitacao->id }} </span>


        <table>
            <thead>
                <tr>
                    <th></th>
                    <th>Dados:</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>De: </th>
                    <td>{{ $email_solicitacao->de }} </td>
                </tr>
                <tr>
                    <th>Para: </th>
                    <td>{{ $email_solicitacao->para }} </td>
                </tr>
                <tr>
                    <th>Assunto: </th>
                    <td>{{ $email_solicitacao->assunto }} </td>
                </tr>
            </tbody>
        </table>

    </header>
    <div class="container">
        <div class="content">
            {{ $email_solicitacao->corpo_email}}
        </div>

        <p>Empresa: Teste Email SA</p>
    </div>
    
</body>
</html>