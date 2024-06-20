@extends('app.layout')
@section('content')
<div class="col-12">
    <h1 class="fs-1">Perfil</h1>

    <div class="row">
        <div class="col-12">
            <hr>
        </div>
    </div>

    <div class="row">

        <div class="col-sm-12 col-md-8 col-lg-8">
            <form action="{{ route('update-user') }}" method="POST" class="row">

                @csrf
                <input type="hidden" name="id" value="{{ Auth::user()->id }}">

                <div class="col-12 col-sm-12 col-md-8 col-lg-8 mb-2">
                    <div class="form-outline" data-mdb-input-init>
                        <input type="text" name="name" id="name" value="{{ Auth::user()->name }}" class="form-control form-control-lg"/>
                        <label class="form-label" for="name">Nome</label>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 mb-2">
                    <div class="form-outline" data-mdb-input-init>
                        <input type="text" name="cpfcnpj" id="cpfcnpj" value="{{ Auth::user()->cpfcnpj }}" class="form-control form-control-lg" disabled/>
                        <label class="form-label" for="cpfcnpj">CPF/CNPJ</label>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8 mb-2">
                    <div class="form-outline" data-mdb-input-init>
                        <input type="email" name="email" id="email" value="{{ Auth::user()->email }}" class="form-control form-control-lg"/>
                        <label class="form-label" for="email">Email</label>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 mb-2">
                    <div class="form-outline" data-mdb-input-init>
                        <input type="date" name="date_of_birth" id="date_of_birth" value="{{ Auth::user()->date_of_birth }}" class="form-control form-control-lg"/>
                        <label class="form-label" for="date_of_birth">Data Nascimento</label>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8 mb-2">
                    <div class="form-outline" data-mdb-input-init>
                        <input type="text" name="address" id="address" value="{{ Auth::user()->address }}" class="form-control form-control-lg"/>
                        <label class="form-label" for="address">Endereço</label>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 mb-2">
                    <div class="form-outline" data-mdb-input-init>
                        <input type="text" name="phone" id="phone" value="{{ Auth::user()->phone }}" class="form-control form-control-lg"/>
                        <label class="form-label" for="phone">Telefone</label>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-8 mb-2">
                    <div class="form-outline" data-mdb-input-init>
                        <input type="text" name="token" id="token" value="{{ Auth::user()->token }}" class="form-control form-control-lg" disabled/>
                        <label class="form-label" for="token">Token</label>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-4 col-lg-4 mb-2">
                    <div class="form-outline" data-mdb-input-init>
                        <input type="text" name="wallet" id="wallet" value="{{ Auth::user()->wallet }}" class="form-control form-control-lg" disabled/>
                        <label class="form-label" for="wallet">Wallet</label>
                    </div>
                </div>
                <div class="col-6 col-sm-12 col-md-12 col-lg-12 mb-2 d-grid gap-2">
                    <button type="submit" class="btn btn-dark">Atualizar</button>
                </div>
            </form>
        </div>

        <div class="col-sm-12 col-md-4 col-lg-4 text-center">
            <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('template/img/avatar.png') }}" class="img-thumbnail avatar" alt="{{ Auth::user()->name }}"/>
            <br>
            <button type="button" id="changePhotoButton" class="btn btn-outline-dark mt-3">Alterar Foto</button>

            <form id="updatePhotoForm" action="{{ route('update-user') }}" method="POST" enctype="multipart/form-data" style="display: none;">
                @csrf
                <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                <input type="file" name="profile_picture" id="profilePictureInput" accept="image/*" style="display: none;">
            </form>
        </div>
        
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        var changePhotoButton = document.getElementById('changePhotoButton');
        var profilePictureInput = document.getElementById('profilePictureInput');
        var updatePhotoForm = document.getElementById('updatePhotoForm');

        changePhotoButton.addEventListener('click', function() {
            profilePictureInput.click();
        });

        profilePictureInput.addEventListener('change', function() {
            if (profilePictureInput.files.length > 0) {
                updatePhotoForm.submit();
            }
        });
    });
</script>
@endsection