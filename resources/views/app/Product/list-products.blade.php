@extends('app.layout')
@section('content')
<div class="col-12">
    <h1 class="fs-1">Produtos</h1>

    <div class="row">
        <div class="col-sm-12 col-md-3 col-lg-3 d-none d-sm-none d-md-block d-sm-block">
            <div class="btn-group shadow-0" role="group" aria-label="Basic example">
                <a href="#" onclick="window.location.reload(true)" class="btn btn-outline-dark" data-mdb-color="dark"  data-mdb-ripple-init>Atualizar</a>
                <a href="#" class="btn btn-outline-dark" data-mdb-color="dark"  data-mdb-ripple-init>Relatórios</a>
            </div>
        </div>
        <div class="col-sm-12 col-md-2 col-lg-2 offset-md-7 offset-lg-7">
            <div class="btn-group shadow-0" role="group" aria-label="Basic example">
                <a href="{{ route('create-product') }}" class="btn btn-outline-dark" data-mdb-color="dark" data-mdb-ripple-init><i class="fas fa-circle-plus"></i></a>
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
                    <th>Detalhes</th>
                    <th>Preço</th>
                    <th>Status</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="https://mdbootstrap.com/img/new/avatars/8.jpg" style="width: 45px; height: 45px" class="rounded-circle"/>
                                <div class="ms-3">
                                    <p class="fw-bold mb-1">{{ $product->name }}</p>
                                    <p class="text-muted mb-0">{{ substr(strip_tags($product->description), 0, 30) }} ...</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <p class="fw-normal mb-1"><small>0 Vendas | 0 Carrinhos | {{ $product->views }} Visualizações</small></p>
                            <p class="text-muted mb-0">Link de venda: <a target="_blank" href="{{ env('APP_URL') }}send-express/{{ $product->id }}/{{ Auth::user()->id }}">{{ env('APP_URL') }}send-express/{{ $product->id }}/{{ Auth::user()->id }}</a></p>
                        </td>
                        <td>
                            <p class="fw-normal mb-1">R$ {{ number_format($product->value, 2, ',', '.') }} <br> {{--<small>Revenda Máx: R$ 1600 Mín: 1800</small>--}}</p> 
                            {{-- <p class="text-muted mb-0">Comissão para revenda: R$ 600</p> --}}
                        </td>
                        <td>
                            <span class="badge {{ $product->statusBadge() }} rounded-pill d-inline">{{ $product->statusLabel() }}</span>
                        </td>
                        <td class="text-center">
                            <form action="{{ route('delete-product') }}" method="POST" class="confirm">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <a title="Editar Produto" href="{{ route('create-product', ['id' => $product->id]) }}" class="btn btn-link btn-sm btn-rounded"> Editar </a>
                                <button title="Excluir Produto" type="submit" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash-can"></i></button>
                            </form>
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
                <h5 class="modal-title text-white" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">...</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-mdb-ripple-init data-mdb-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-success" data-mdb-ripple-init>Filtrar</button>
            </div>
        </div>
    </div>
</div>
@endsection