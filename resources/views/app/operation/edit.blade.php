@extends('layouts.main')

@section('titleName', 'Opération - Ajouter')

@section('main')
    <form action="{{ route('operation.modifier') }}" method="POST">
        <input type="hidden" name="id" value="{{ $id }}">
        @csrf
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="date_realisation">Date</label>
                                        <input type="date" id="date_realisation" name="date_realisation" class="form-control" value="{{ old('date_realisation', $date_realisation) }}">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="categorie_id">Catégorie</label>
                                        <select name="categorie_id" id="categorie_id" class="form-control  custom-select @error('categorie_id') is-invalid @enderror">
                                            <option disabled="">Choisissez une valeur</option>
                                            @foreach($categories as $categorie)
                                                <option value="{{ $categorie->id }}" {{ old('categorie_id', $categorie_id) == $categorie->id ? ' selected=""' : '' }}>{{ $categorie->designation }}</option>
                                            @endforeach
                                        </select>
                                        @error('categorie_id')
                                        <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="designation">Désignation</label>
                                <input type="text" id="designation" name="designation" class="form-control @error('designation') is-invalid @enderror"  value="{{ old('designation', $designation) }}">
                                @error('designation')
                                <span class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="debit">Débit</label>
                                        <input type="text" id="debit" name="debit" class="form-control"  value="{{ old('debit', $debit) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="credit">Crédit</label>
                                        <input type="text" id="credit" name="credit" class="form-control"  value="{{ old('credit', $credit) }}">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>

            </div>
            <div class="row">
                <div class="col-12">
                    <a href="{{ route('operation') }}" class="btn btn-secondary">Annuler</a>
                    <input type="submit" value="Modifier" class="btn btn-success float-right">
                </div>
            </div>
        </section>
@endsection
