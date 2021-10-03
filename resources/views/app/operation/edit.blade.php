@extends('layouts.main')

@section('titleName', 'Opération - Ajouter')

@section('main')


            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            <section class="content">
                                <form action="{{ route('operation.modifier') }}" method="POST" id="formUpdate">
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <input type="hidden" name="compte_bancaire_id" value="{{ $compte_bancaire->id }}">
                                    <input type="hidden" id="documentoperations_id" name="documentoperations_id" value="{{ json_encode([]) }}">
                                    @csrf
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
            </form>
                            <div class="form-group">
                                <label for="designation">Fichiers</label>
                                <div class="dropzone" id="file-dropzone"></div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>

            </div>

            <div class="row">
                <div class="col-12">
                    <a href="{{ route('operation', [ 'compte_bancaire_id' => $compte_bancaire->id]) }}" class="btn btn-secondary">Annuler</a>
                    <input type="submit" value="Modifier" class="modifier btn btn-success float-right">
                </div>
            </div>
        </section>
@endsection

@section('css')
    <link rel="stylesheet" href="/adminlte/plugins/dropzone/min/dropzone.min.css">
    <link rel="stylesheet" href="/adminlte/plugins/dropzone/min/basic.min.css">

@endsection


@section('js')
    <script src="/adminlte/plugins/dropzone/min/dropzone.min.js"></script>

    <script type="text/javascript">
        Dropzone.autoDiscover = false;
        $(document).ready(function() {

            let urlTelecharger = "{{ route('documentoperation.telecharger', ['id' => 'idDocument']) }}";

            $('.modifier').on('click', function(e) {
                $('#formUpdate').submit();
            });

            function removeA(arr) {
                var what, a = arguments, L = a.length, ax;
                while (L > 1 && arr.length) {
                    what = a[--L];
                    while ((ax= arr.indexOf(what)) !== -1) {
                        arr.splice(ax, 1);
                    }
                }
                return arr;
            }

            $('#file-dropzone').dropzone({
                uploadMultiple: false,
                parallelUploads: 1,
                url: '{{route('documentoperation.enregistrer', ['operation_id' => $id])}}',
                acceptedFiles: ".jpeg,.jpg,.png,.gif,.pdf,.xls,.xlsx",
                addRemoveLinks: true,
                maxFilesize: 8,
                dictDefaultMessage: "Déplacer votre fichier ici ou cliquer pour le téléverser.",
                dictRemoveFile: 'Supprimer',
                dictFileTooBig: 'Le fichier est trop volumineux',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                init:function() {
                    let myDropzone = this;
                    $.ajax({
                        url: "{{ route('documentoperation.liste', ['operation_id' => $id]) }}",
                        type: 'GET',
                        dataType: 'json',
                        success: function(data){
                            $.each(data, function (key, value) {
                                let file = {name: value.name, size: value.size};
                                myDropzone.options.addedfile.call(myDropzone, file);
                                myDropzone.options.thumbnail.call(myDropzone, file, value.path);
                                myDropzone.emit("complete", file);
                            });
                        }
                    });
                },
                removedfile: function (file) {
                    var name = file.upload.filename;
                    $.ajax({
                        type: 'POST',
                        url: '{{route('documentoperation.supprimer')}}',
                        data: {"_token": "{{ csrf_token() }}",  id: file.serverId},
                        success: function (response) {
                            let ids = JSON.parse($('#documentoperations_id').val());
                            removeA(ids, response.id);
                            $('#documentoperations_id').val(JSON.stringify(ids));
                        }
                    });
                    var fileRef;
                    return (fileRef = file.previewElement) != null ?
                        fileRef.parentNode.removeChild(file.previewElement) : void 0;
                },
                error: function(file, message, xhr) {
                    $(file.previewElement).remove();
                },
                success: function (file, response) {
                    let ids = JSON.parse($('#documentoperations_id').val());
                    ids.push(response.id);
                    $('#documentoperations_id').val(JSON.stringify(ids));
                    file.serverId = response.id;
                    $(".dz-preview:last-child").attr('data-id' ,response.id);
                    if(response != 0){
                        // Download link
                        var anchorEl = document.createElement('a');
                        anchorEl.setAttribute('class','dz-remove');
                        anchorEl.setAttribute('href',urlTelecharger.replace('idDocument', response.id));
                        anchorEl.setAttribute('target','_blank');
                        anchorEl.innerHTML = "Télécharger";
                        file.previewTemplate.appendChild(anchorEl);
                    }

                },
            });
        });
    </script>
@endsection
