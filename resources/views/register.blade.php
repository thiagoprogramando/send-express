<!DOCTYPE html>
<html lang="pt-br">
    <head>

        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        
        <title>{{ env('APP_NAME') }}</title>
        
        <link rel="icon" href="{{ asset('template/img/logo_vermelha.png') }}" type="image/x-icon" />
        
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
        <link rel="stylesheet" href="{{ asset('template/css/mdb.min.css') }}"/>
        <link rel="stylesheet" href="{{ asset('template/css/style.css') }}"/>
    </head>
    <body class="container">

        <div class="row mt-4">
            <div class="col-sm-12 col-md-6 col-lg-6 login-background-marketing d-none d-sm-none d-md-block d-sm-block">
                <img src="{{ asset('template/img/logo.png') }}" class="logo">
            </div>

            <div class="col-sm-12 col-md-6 col-lg-6 login-background d-flex align-items-center justify-content-center">
                <form action="{{ route('registrer-user') }}" method="POST" class="p-5">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 mb-3">
                            <h2 class="fs-2 text-white">Olá,</h2>
                            <h4 class="fs-4">Cadastre-se e faça parte!</h4>
                        </div>
                        <div class="col-sm-12 col-md-8 col-lg-8">
                            <div class="form-outline mb-2" data-mdb-input-init>
                                <input type="text" name="name" id="name" class="form-control form-control-lg text-white" required/>
                                <label class="form-label" for="name">Nome</label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4">
                            <div class="form-outline mb-2" data-mdb-input-init>
                                <input type="number" name="cpfcnpj" id="cpfcnpj" class="form-control form-control-lg text-white" required/>
                                <label class="form-label" for="cpfcnpj">CPF ou CNPJ</label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-8 col-lg-8">
                            <div class="form-outline mb-2" data-mdb-input-init>
                                <input type="email" name="email" id="email" class="form-control form-control-lg text-white" required/>
                                <label class="form-label" for="email">E-mail</label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4">
                            <div class="form-outline mb-2" data-mdb-input-init>
                                <input type="password" name="password" id="password" class="form-control form-control-lg text-white" required/>
                                <label class="form-label" for="password">Senha</label>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-12 d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-outline-light btn-lg">Cadastrar-me</button>
                        </div>
                        <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                            <p>Já possui conta? <a class="text-white" href="{{ route('login') }}">Faça login</a></p>
                            <p class="text-white">ou</p>
                            <p>Esqueceu sua senha? <a class="text-white" href="{{ route('forgout') }}">Recuperar</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    
        <script type="text/javascript" src="{{ asset('template/js/mdb.umd.min.js') }}"></script>
    </body>
</html>
