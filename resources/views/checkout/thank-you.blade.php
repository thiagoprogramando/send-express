<!doctype html>
<html>

    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        
        <title>{{ env('APP_NAME') }}</title>

        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css' rel='stylesheet'>
        <link href='https://use.fontawesome.com/releases/v5.7.2/css/all.css' rel='stylesheet'>
        
        <link rel="stylesheet" href="{{ asset('template/checkout/style.css') }}">
    </head>

    <body className='snippet-body'>
        
        <div class="container">
            <div class="box-1 bg-light">
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset('template/img/logo_vermelha.png') }}" class="pic rounded-circle">
                    <p class="ps-2 name">SendExpress da IFUTURE</p>
                </div>
            </div>
            <div class="box-inner-1 pb-3 mb-3 p-5">
                <h1>Obrigado!</h1>
                <p>Recebemos o seu pagamento e estamos processando os dados da sua compra.</p>
            </div>
        </div>

        <script type='text/javascript' src='{{ asset('template/checkout/bootstrap.bundle.min.js') }}'></script>
    </body>

</html>
