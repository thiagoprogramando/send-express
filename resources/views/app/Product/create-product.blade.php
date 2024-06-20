@extends('app.layout')
@section('content')
<div class="col-12">
    <h1 class="fs-1">{{ $product->name ?: 'Configurando Produto' }}</h1>

    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="btn-group shadow-0" role="group" aria-label="Basic example">
                <a href="#" onclick="window.location.reload(1)" class="btn btn-outline-dark" data-mdb-color="dark"  data-mdb-ripple-init>Atualizar</a>
                <a href="{{ route('list-product') }}" class="btn btn-outline-dark" data-mdb-color="dark"  data-mdb-ripple-init>Cancelar</a>
            </div>
            <hr>
        </div>
    </div>
</div>

<div class="col-12 col-sm-12 col-md-8 col-lg-8 mt-3 divisor-right">
    <form action="{{ route('update-product') }}" method="POST" class="row" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="id" value="{{ $product->id }}">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-2">
            <div class="form-outline" data-mdb-input-init>
                <input type="text" name="name" id="name" value="{{ $product->name }}" class="form-control form-control-lg"/>
                <label class="form-label" for="name">Nome</label>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
            <div class="form-outline" data-mdb-input-init>
                <input type="text" name="value" id="value" value="{{ $product->value }}" class="form-control form-control-lg"/>
                <label class="form-label" for="value">Valor</label>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-2">
            <select name="status" class="form-control form-control-lg">
                <option value="{{ $product->status ?: 0 }}" selected>Status</option>
                <option value="1" @selected($product->status == 1)>Ativo</option>
                <option value="0" @selected($product->status == 0)>Pendente</option>
                <option value="2" @selected($product->status == 2)>Bloqueado</option>
                <option value="3" @selected($product->status == 3)>Sem estoque/indiponível</option>
            </select>
        </div>

        <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-2">
            <textarea class="form-control" name="description" id="editor" rows="3">{{ $product->description }}</textarea>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-2">
            <div class="form-outline" data-mdb-input-init>
                <input type="text" name="url" id="url" value="{{ $product->url }}" class="form-control form-control-lg"/>
                <label class="form-label" for="url">Url de redirecionamento</label>
            </div>
        </div>

        <div class="col-6 col-sm-6 col-md-6 col-lg-6 mb-2">
            <select name="credit_opt" class="form-control form-control-lg">
                <option value="{{ $product->credit_opt ?: 0 }}" selected>Cartão de crédito</option>
                <option value="1" @selected($product->credit_opt == 1)>Aceitar</option>
                <option value="0">Não Aceitar</option>
            </select>
        </div>
        <div class="col-6 col-sm-6 col-md-6 col-lg-6 mb-2">
            <div class="form-outline" data-mdb-input-init>
                <input type="number" max="12" name="credit_installments" id="credit_installments" value="{{ $product->credit_installments }}" class="form-control form-control-lg"/>
                <label class="form-label" for="credit_installments">Parcelas</label>
            </div>
        </div>
        <div class="col-6 col-sm-6 col-md-6 col-lg-6 mb-2">
            <select name="boleto_opt" class="form-control form-control-lg">
                <option value="{{ $product->boleto_opt ?: 0 }}" selected>Boleto</option>
                <option value="1" @selected($product->boleto_opt == 1)>Aceitar</option>
                <option value="0">Não Aceitar</option>
            </select>
        </div>
        <div class="col-6 col-sm-6 col-md-6 col-lg-6 mb-2">
            <div class="form-outline" data-mdb-input-init>
                <input type="number" max="24" name="boleto_installments" id="boleto_installments" value="{{ $product->boleto_installments }}" class="form-control form-control-lg"/>
                <label class="form-label" for="boleto_installments">Parcelas</label>
            </div>
        </div>
        <div class="col-6 col-sm-6 col-md-6 col-lg-6 mb-2">
            <select name="pix_opt" class="form-control form-control-lg">
                <option value="{{ $product->pix_opt ?: 0 }}" selected>Pix</option>
                <option value="1" @selected($product->pix_opt == 1)>Aceitar</option>
                <option value="0">Não Aceitar</option>
            </select>
        </div>
        <div class="col-6 col-sm-6 col-md-6 col-lg-6 mb-2">
            <div class="form-outline" data-mdb-input-init>
                <input type="number" max="24" name="pix_installments" id="pix_installments" value="{{ $product->pix_installments }}" class="form-control form-control-lg"/>
                <label class="form-label" for="pix_installments">Parcelas</label>
            </div>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-2">
            <label for="file" class="form-label">Qual arquivo será encaminhado? <span class="badge badge-dark">*Será disparado ao cliente após confirmação (PDF, Zip, Imagens)</span></label>
            <input class="form-control" type="file" name="file" id="file" accept="image/*,.pdf,.zip"/>
        </div>
        <div class="col-6 col-sm-12 col-md-12 col-lg-12 mb-2 d-grid gap-2">
            <button type="submit" class="btn btn-dark">Salvar</button>
        </div>
    </form>
</div>

<div class="col-12 col-sm-12 col-md-4 col-lg-4 mt-3">
    
    <form action="{{ route('send-image-product') }}" method="POST" class="row" enctype="multipart/form-data" id="imageForm">
        @csrf
        <input type="hidden" name="id_product" value="{{ $product->id }}">
        <div class="col-12">
            <label for="images" class="form-label">Selecione às imagens <span class="badge badge-dark">*Recomendação: 500px por 500px</span></label>
            <input class="form-control" type="file" name="file" id="images" accept="image/*" onchange="submitForm()"/>
        </div>
    </form>

    <div class="col-12 mt-3">
        <div class="row">
            @foreach ($images as $image)
                <div class="col-6 mb-2">
                    <div class="card">
                        <img src="{{ asset('storage/'.$image->file) }}" class="card-img-top"/>
                        <div class="card-body text-center">
                            <a href="{{ route('delete-image-product', ['id' => $image->id]) }}" class="btn btn-sm btn-outline-danger" data-mdb-ripple-init><i class="fas fa-trash-can"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>

<script src="{{ asset('template/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('template/ckeditor/sample.js') }}"></script>
<script>
	initSample();

    function submitForm() {
        document.getElementById('imageForm').submit();
    }
</script>
@endsection