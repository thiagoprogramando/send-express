<!doctype html>
<html>

    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        
        <title>{{ env('APP_NAME') }}</title>

        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css' rel='stylesheet'>
        <link href='https://use.fontawesome.com/releases/v5.7.2/css/all.css' rel='stylesheet'>
        
        <link rel="stylesheet" href="{{ asset('template/checkout/style.css') }}">
        <script src="{{ asset('template/checkout/jquery.js') }}"></script>
    </head>

    <body className='snippet-body'>
        <div class="container d-lg-flex">
            <div class="box-1 bg-light user">
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset('template/img/logo_vermelha.png') }}" class="pic rounded-circle">
                    <p class="ps-2 name">SendExpress da IFUTURE</p>
                </div>
                <div class="box-inner-1 pb-3 mb-3 ">
                    <div class="d-flex justify-content-between mb-3 userdetails">
                        <p class="fw-bold">{{ $product->name }}</p>
                        <p class="fw-lighter">R$ {{ $product->value }}</p>
                    </div>
                    <div id="my" class="carousel slide carousel-fade img-details" data-bs-ride="carousel" data-bs-interval="2000">
                        <div class="carousel-indicators">
                            @foreach ($images as $key => $image)
                                <button type="button" data-bs-target="#my" data-bs-slide-to="{{ $key }}" @if($loop->first) class="active" @endif aria-current="true" aria-label="Slide {{ $key }}"></button>
                            @endforeach
                        </div>
                        <div class="carousel-inner">
                            @foreach ($images as $key => $image)
                                <div class="carousel-item @if($loop->first) active @endif">
                                    <img src="{{ asset('storage/'.$image->file) }}" class="d-block w-100">
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#my" data-bs-slide="prev">
                            <div class="icon">
                                <span class="fas fa-arrow-left"></span>
                            </div>
                            <span class="visually-hidden">Previous</span>
                        </button>

                        <button class="carousel-control-next" type="button" data-bs-target="#my" data-bs-slide="next">
                            <div class="icon">
                                <span class="fas fa-arrow-right"></span>
                            </div>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                    <p class="dis info my-3">
                        {!! $product->description !!}
                    </p>
                </div>
            </div>
            <div class="box-2">
                <div class="box-inner-2">
                    <div>
                        <p class="fw-bold">Detalhes do pagamento</p>
                        <p class="dis mb-3">Conclua sua compra fornecendo seus dados de pagamento</p>
                    </div>
                    <form action="{{ route('send-sale') }}" method="POST">
                        @csrf

                        <input type="hidden" name="id_seller" value="{{ $seller }}">
                        <input type="hidden" name="id_product" value="{{ $product->id }}">
                        <input type="hidden" name="value" value="{{ $product->value }}">

                        <div class="radiobtn mb-3">
                            @if($product->credit_opt)   <input type="radio" name="method" value="CREDIT_CARD" data-max-installments="{{ $product->credit_installments }}" id="one"> @endif
                            @if($product->pix_opt)      <input type="radio" name="method" value="PIX" data-max-installments="{{ $product->pix_installments }}" id="two"> @endif
                            @if($product->boleto_opt)   <input type="radio" name="method" value="BOLETO" data-max-installments="{{ $product->boleto_installments }}" id="three"> @endif
    
                            @if($product->credit_opt)
                                <label for="one" class="box py-2 first">
                                    <div class="d-flex align-items-start">
                                        <span class="circle"></span>
                                        <div class="course">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <span class="fw-bold">
                                                    Cartão de crédito
                                                </span>
                                            </div>
                                            <span>Até {{ $product->credit_installments }}x</span>
                                        </div>
                                    </div>
                                </label>
                            @endif
    
                            @if($product->pix_opt)
                                <label for="two" class="box py-2 second">
                                    <div class="d-flex">
                                        <span class="circle"></span>
                                        <div class="course">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <span class="fw-bold">
                                                    Pix
                                                </span>
                                            </div>
                                            <span>Até {{ $product->pix_installments }}x</span>
                                        </div>
                                    </div>
                                </label>
                            @endif
    
                            @if($product->boleto_opt)
                                <label for="three" class="box py-2 third">
                                    <div class="d-flex">
                                        <span class="circle"></span>
                                        <div class="course">
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <span class="fw-bold">
                                                    Boleto
                                                </span>
                                            </div>
                                            <span>Até {{ $product->boleto_installments }}x</span>
                                        </div>
                                    </div>
                                </label>
                            @endif
                        </div>

                        <div class="row mb-2">
                            <div class="col-12 col-lg-6">
                                <p class="dis fw-bold">Email</p>
                                <input class="form-control" name="email" type="email" required>
                            </div>
                            <div class="col-12 col-lg-6">
                                <p class="dis fw-bold">N° telefone</p>
                                <input class="form-control" name="phone" type="number" placeholder="(DD) 99999-9999" required>
                            </div>
                        </div>
                        <div>
                            {{-- <div id="credit_card" class="d-none">
                                <p class="dis fw-bold mb-2">Detalhes do cartão</p>
                                <div class="d-flex align-items-center justify-content-between card-atm border rounded">
                                    <div class="fa fa-credit-card ps-3"></div>
                                    <input type="number" name="creditCardNumber" class="form-control" placeholder="Número">
                                    <div class="d-flex w-50">
                                        <input type="text" name="dueDate" class="form-control px-0" placeholder="MM/AA">
                                        <input type="number" name="ccv" maxlength=3 class="form-control px-0" placeholder="CVV">
                                    </div>
                                </div>
                            </div> --}}
                            <div class="my-3 cardinstallments">
                                <p class="dis fw-bold mb-2">N° Parcelas</p>
                                <input class="form-control" type="number" name="installments" id="installments">
                            </div>
                            <div class="my-3 cardname">
                                <p class="dis fw-bold mb-2">Nome do Titular</p>
                                <input class="form-control" type="text" name="name" required>
                            </div>
                            <div class="my-3 cardname">
                                <p class="dis fw-bold mb-2">CPF ou CNPJ</p>
                                <input class="form-control" type="number" name="cpfcnpj" placeholder="Apenas números" required>
                            </div>
                            <div class="address">
                                <div class="d-flex flex-column dis">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <p class="fw-bold">Total</p>
                                        <p class="fw-bold">R$ {{ $product->value }}</p>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-2">Finalizar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script type='text/javascript' src='{{ asset('template/checkout/bootstrap.bundle.min.js') }}'></script>
        <script>
            $(document).ready(function() {
                $('input[name="method"]').change(function() {
                    
                    var selectedMethod = $(this).val();
                    var maxInstallments = $(this).data('max-installments');

                    $('#installments').attr('max', maxInstallments);
                    $('#installments').val(1);

                    // if(selectedMethod === 'CREDIT_CARD') {
                    //     $('#credit_card').removeClass('d-none');
                    // } else {
                    //     $('#credit_card').addClass('d-none');
                    // }
                });

                $('#installments').on('input', function() {

                    var maxInstallments = parseInt($(this).attr('max'), 10);
                    var currentValue = parseInt($(this).val(), 10);

                    if (currentValue > maxInstallments) {
                        $(this).val(maxInstallments);
                    }
                });
            });
        </script>
        
    </body>

</html>
