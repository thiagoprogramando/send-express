@extends('app.layout')
@section('content')

<div class="col-12">
    <h1 class="fs-1">Vendas</h1>

    <div class="row">
        <div class="col-sm-12 col-md-3 col-lg-3 d-none d-sm-none d-md-block d-sm-block">
            <div class="btn-group shadow-0" role="group" aria-label="Basic example">
                <a href="#" onclick="window.location.reload(true)" class="btn btn-outline-dark" data-mdb-color="dark"  data-mdb-ripple-init>Atualizar</a>
                <a href="#" class="btn btn-outline-dark" data-mdb-color="dark"  data-mdb-ripple-init>Relatórios</a>
            </div>
        </div>
        <div class="col-sm-12 col-md-2 col-lg-2 offset-md-7 offset-lg-7">
            <div class="btn-group shadow-0" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-outline-dark" data-mdb-color="dark" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#exampleModal" data-mdb-ripple-init><i class="fas fa-filter"></i></button>
                <button type="button" class="btn btn-outline-dark" data-mdb-color="dark"  data-mdb-ripple-init><i class="fas fa-file-excel"></i></button>
            </div>
        </div>
        <div class="col-12">
            <hr>
        </div>
    </div>
</div>

<div class="col-12 mt-3">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 bg-white">
            <thead class="bg-light">
                <tr>
                    <th>Produto</th>
                    <th>Cliente</th>
                    <th>Detalhes</th>
                    <th>Preço</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $sale)
                    <tr>
                        <td>
                            <p class="fw-bold mb-1">{{ $sale->product->name }}</p>
                            <p class="text-muted mb-0">{{ substr(strip_tags($sale->product->description), 0, 30) }} ...</p>
                        </td>
                        <td class="d-flex align-items-center">
                            <img src="{{ $sale->client->profile_picture ? asset('storage/' . $sale->client()->profile_picture) : asset('template/img/avatar.png') }}" style="width: 35px; height: 35px" class="rounded-circle"/>
                            <div class="ms-3">
                                <p class="fw-bold mb-1">{{ $sale->client->name }}</p>
                                <p class="text-muted mb-0">{{ $sale->client->cpfcnpj }} | {{ $sale->client->email }} | {{ $sale->client->phone }}</p>
                            </div>
                        </td>
                        <td>
                            <p class="fw-normal mb-1">{{ $sale->methodLabel() }} - {{ $sale->installments }}x | <span class="badge {{ $sale->statusBadge() }} rounded-pill d-inline">{{ $sale->statusLabel() }}</span></p> 
                            <p class="text-muted mb-0">{{ \Carbon\Carbon::parse($sale->created_at)->format('d/m/Y') }}</p>
                        </td>
                        <td>
                            <p class="fw-normal mb-1">R$ {{ number_format($sale->product->value, 2, ',', '.') }} </p> 
                            <p class="text-muted mb-0">Link de pagamento: <a target="_blank" href="{{ $sale->url }}">{{ $sale->url }}</a></p>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white" id="exampleModalLabel">Filtro de Vendas</h5>
                <button type="button" class="btn-close" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('list-sales') }}" method="GET">
                <div class="modal-body">
                    <div class="row p-3">
                        <div class="col-6 col-sm-12 col-md-6 col-lg-6 mb-2">
                            <div class="form-outline" data-mdb-input-init>
                                <input type="date" name="created_at" id="created_at" class="form-control form-control-lg"/>
                                <label class="form-label" for="created_at">Data</label>
                            </div>
                        </div>
                        <div class="col-6 col-sm-6 col-md-6 col-lg-6 mb-2">
                            <select name="status" class="form-control form-control-lg">
                                <option value="" selected>Status</option>
                                <option value="approved">Aprovado</option>
                                <option value="pendent">Pendente</option>
                                <option value="cancel">Cancelado</option>
                                <option value="approved & send">Aprovado e Enviado</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                            <select name="method" class="form-control form-control-lg">
                                <option value="" selected>Forma de Pagamento</option>
                                <option value="CREDIT_CARD">Cartão de crédito/Débito</option>
                                <option value="PIX">Pix</option>
                                <option value="BOLETO">Boleto</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                            <select name="id_client" class="select-user">
                                <option value="" selected>Cliente</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-2">
                            <select name="id_product" class="select-product">
                                <option value="" selected>Produto</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-mdb-ripple-init data-mdb-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-success" data-mdb-ripple-init>Filtrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection