<!DOCTYPE html>
<html lang="pt-br">
  <head>

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge"/>
    
    <title>{{ env('APP_NAME') }}</title>
    
    <link rel="icon" href="{{ asset('template/img/logo_vermelha.png') }}" type="image/x-icon"/>
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
    <link rel="stylesheet" href="{{ asset('template/css/mdb.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('template/css/style.css') }}"/>

    <script src="{{ asset('template/js/sweetalert.js')}}"></script>
  </head>
  <body class="container">

    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <div class="container-fluid">
        
            <button data-mdb-collapse-init class="navbar-toggler" type="button" data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars text-white"></i>
            </button>
    
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                
                <a class="navbar-brand mt-2 mt-lg-0" href="#">
                    <img src="{{ asset('template/img/logo.png') }}" height="50" alt="Logo" loading="lazy"/>
                </a>
                
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('app') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-reset" href="#">Vendas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-reset" href="{{ route('list-product') }}">Produtos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-reset" href="#"><i class="fas fa-user-tag"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-reset" href="#"><i class="fas fa-file-invoice-dollar"></i></a>
                    </li>
                </ul>
            </div>

            <div class="d-flex align-items-center">

                <form class="d-flex input-group w-auto">
                    <input type="search" class="form-control rounded" placeholder="Pesquisar" aria-label="Search" aria-describedby="search-addon"/>
                    <button class="input-group-text border-0" id="search-addon">
                      <i class="fas fa-search text-white"></i>
                    </button>
                </form>
                <div class="dropdown">
                    <a data-mdb-dropdown-init class="text-white me-3 dropdown-toggle hidden-arrow" href="#" id="navbarDropdownMenuLink" role="button" aria-expanded="false">
                        <i class="fas fa-bell"></i>
                        <span class="badge rounded-pill badge-notification bg-danger">1</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                        <li>
                            <a class="dropdown-item" href="#">Some news</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">Another news</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </li>
                    </ul>
                </div>

                <div class="dropdown">
                    <a data-mdb-dropdown-init class="dropdown-toggle d-flex align-items-center hidden-arrow" href="#" id="navbarDropdownMenuAvatar" role="button" aria-expanded="false">
                        <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('template/img/avatar.png') }}" class="rounded-circle" height="25" alt="Black and White Portrait of a Man" loading="lazy"/>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" -labelledby="navbarDropdownMenuAvatar">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile') }}">Perfil</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">Configurações</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}">Sair</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="card mt-5">
        <div class="row p-5">
            @yield('content')
        </div>
    </div>

    <footer class=" text-center text-white bg-dark">
        <div class="container p-4">
  
            <section class="mb-4">
                <a class="btn btn-primary btn-floating m-1" style="background-color: #ac2bac" href="#!" role="button"><i class="fab fa-instagram"></i></a>
                <a class="btn btn-primary btn-floating m-1" style="background-color: #0082ca" href="#!" role="button"><i class="fab fa-linkedin-in"></i></a>
            </section>
  
            <section class="">
                <form action="">
                    <div class="row d-flex justify-content-center">
                        <div class="col-auto">
                            <p class="pt-2">
                                <strong>Faça parte da nossa newsletter</strong>
                            </p>
                        </div>
                        <div class="col-md-5 col-12">
                            <div class="form-outline form-white mb-4" data-mdb-input-init>
                                <input type="email" id="newsletter" class="form-control" />
                                <label class="form-label" for="newsletter">E-mail</label>
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-outline-light mb-4">
                                cadastrar-me
                            </button>
                        </div>
                    </div>
                </form>
            </section>
        </div>

        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
            © {{ date('Y') }} Copyright: <a class="text-white" href="https://ifuture.cloud/">ifuture.cloud</a>
        </div>
    </footer>
    
    <script type="text/javascript" src="{{ asset('template/js/mdb.umd.min.js') }}"></script>
    <script type="text/javascript">
        @if(session('error'))
            Swal.fire({
                title: 'Erro!',
                text: '{{ session('error') }}',
                icon: 'error',
                timer: 2000
            })
        @endif
        
        @if(session('success'))
            Swal.fire({
                title: 'Sucesso!',
                text: '{{ session('success') }}',
                icon: 'success',
                timer: 2000
            })
        @endif

        document.addEventListener('DOMContentLoaded', function() {

            var forms = document.querySelectorAll('form.confirm');
            forms.forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();  // Impede o envio imediato do formulário

                    Swal.fire({
                        title: 'Tem certeza?',
                        text: 'Você realmente deseja executar esta ação?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sim',
                        confirmButtonColor: '#008000',
                        cancelButtonText: 'Não',
                        cancelButtonColor: '#FF0000',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();  // Envia o formulário se confirmado
                        }
                    });
                });
            });
        });
        
    </script>
  </body>
</html>
