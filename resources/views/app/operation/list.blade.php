@extends('layouts.main')

@section('titleName',  $compteBancaire->entreprise->designation . ' - Compte bancaire  : ' . $compteBancaire->designation  )

@section('css')
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style>
    .badge.even-larger-badge {
    font-size: 90%;
    }
    </style>
@endsection

@section('main')

    <section class="content">
        <div class="card ">
            <div class="card-body">
                Le solde en banque est de {{ number_format($compteBancaire->solde() ,2, '.', ' ') }} €
            </div>
        </div>

    <div class="card">
        <div class="card-header">
            Liste des opérations
            <div class="card-tools">
                <a href="javascript:void(0);" class="exporter btn btn-primary"><i class="fas fa-file-export mr-2"></i>Exporter</a>
                <a href="{{ route('operation.creer', ['compte_bancaire_id' => $compteBancaire->id]) }}" class="btn btn-primary"><i class="fas fa-plus mr-2"></i>Ajouter</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-2 offset-md-1">
                    <div class="form-group row">
                        <label for="exporter" class="col-sm-8 col-form-label text-right">Exporter</label>
                        <div class="col-sm-4">
                            <select name="exporter" id="exporter" class="form-control  custom-select @error('categorie_id') is-invalid @enderror">
                                <option>Tous</option>
                                <option value="oui">Oui</option>
                                <option value="non">Non</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group row">
                        <label for="avec_piece" class="col-sm-8 col-form-label text-right">Avec pièce</label>
                        <div class="col-sm-4">
                        <select name="avec_piece" id="avec_piece" class="form-control  custom-select @error('categorie_id') is-invalid @enderror">
                            <option>Tous</option>
                            <option value="oui">Oui</option>
                            <option value="non">Non</option>
                        </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group row">
                        <label for="pointee" class="col-sm-8 col-form-label text-right">Pontée</label>
                        <div class="col-sm-4">
                        <select name="pointee" id="pointee" class="form-control  custom-select @error('categorie_id') is-invalid @enderror">
                            <option>Tous</option>
                            <option value="oui">Oui</option>
                            <option value="non">Non</option>
                        </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="submit" value="Actualiser" class="actualiser btn btn-primary float-right">
                </div>
            </div>

            <table class="table table-bordered operation-datatable">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Designation</th>
                    <th>Debit</th>
                    <th>Credit</th>
                    <th>Catégorie</th>
                    <th>Pièce</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div></div>
    </section>

    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    Suppression d'une opération
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer l'opération #<span class="debug-id"></span> ?</p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <a class="btn btn-danger btn-ok" href="#">Supprimer</a>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')

    <script src="/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/adminlte//plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript">

        $(document).ready(function() {
            let urlSupprimer = '{{ route('operation.supprimer', ['id' => 'idOperation']) }}';
            let urlEditer= '{{ route('operation.editer', ['id' => 'idOperation']) }}';

            $('.exporter').on('click', function(e) {
               let url = "{{ route('operationexport.creer', ['compte_bancaire_id' => $compteBancaire->id]) }}";

                $.ajax({
                    url: '{{ route('operationexport.creer', ['compte_bancaire_id' => $compteBancaire->id]) }}',
                    type: 'get',
                    dataType: 'json',
                    complete:function(response) {
                        if(response.status !== 200 || !response.responseJSON.status || response.responseJSON.status !== 'OK') {
                            if(response.responseJSON.message) {
                                toastr.error(response.responseJSON.message);
                            } else {
                                toastr.error("Une erreur inconnue est survenue lors de la génération de l'export");
                            }
                            return;
                        }
                        if(response.responseJSON.message) {
                            toastr.success(response.responseJSON.message);
                        } else {
                            toastr.success("L'export a été correctement généré, le téléchargement va débuter");
                        }

                        let params = "id="+ response.responseJSON.data.id;
                        let req = new XMLHttpRequest();
                        req.open("GET", "{{ route('operationexport.telecharger') }}?"+params, true);
                        req.responseType = "blob";
                        req.setRequestHeader('X-CSRF-Token', $('meta[name="_token"]').attr('content'));
                        req.onreadystatechange = function () {
                            if (req.readyState === 4 && req.status === 200) {

                                const filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                                const matches = filenameRegex.exec(req.getResponseHeader('Content-Disposition'));
                                const filename = (matches != null && matches[1] ? matches[1] : response.responseJSON.data.id + '.zip');

                                if (typeof window.navigator.msSaveBlob === 'function') {
                                    window.navigator.msSaveBlob(req.response, filename);
                                } else {
                                    let blob = req.response;
                                    let link = document.createElement('a');
                                    link.href = window.URL.createObjectURL(blob);
                                    link.download = filename;

                                    document.body.appendChild(link);

                                    link.click();
                                }
                            }
                            if (req.readyState === 4 && req.status !== 200) {
                                toastr.error("Une erreur inconnue est survenue lors du téléchargement");
                            }
                        }
                        req.send();

                    }
                });


            });

            $('.operation-datatable').on('click', '.delete', function(e) {
                $('#confirm-delete .btn-ok').attr('href', urlSupprimer.replace('idOperation', $(this).data('id') ));
                $('#confirm-delete .debug-id').html($(this).data('id'));
                $('#confirm-delete').modal();
            });

            $('.actualiser').on('click',  function(e) {
                let table = $('.operation-datatable').DataTable();
                table.ajax.reload();
            });

            $('.operation-datatable').on('click', '.edit', function(e) {
                window.location.href = urlEditer.replace('idOperation', $(this).data('id'));
            });

            $('.operation-datatable').DataTable( {
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('operation.liste', ['compte_bancaire_id' => $compteBancaire->id]) }}",
                    data :function ( d ) {
                        d.avec_piece= $('select[name="avec_piece"]').val();
                        d.pointee= $('select[name="pointee"]').val();
                        d.exporter= $('select[name="exporter"]').val();
                    }
                },
                language: {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
                },
                "order": [[ 0, "desc" ]],
                columnDefs: [
                    {
                        targets: 0,
                        render: function (data, type, row, meta) {
                            if(row.pointe){
                                return `<span class="badge  even-larger-badge badge-success display-4">` + row.id + `</span>`;
                            } else {
                                return `<span class="badge  even-larger-badge badge-danger display-4"> ` + row.id + `</span>`;
                            }
                        },
                    },
                    {
                        targets: 1,
                        render: function (data, type, row, meta) {
                            if(row.date_realisation === null) {
                                return '-';
                            } else {
                                return row.date_realisation_tostring;
                            }
                        }
                    },
                    {
                        targets: 2,
                        render: function (data, type, row, meta) {
                            return row.designation;
                        }
                    },
                    {
                        targets: 3,
                        className: 'text-right',
                        render: function (data, type, row, meta) {
                            return row.debit_tostring;
                        }
                    },
                    {
                        targets: 4,
                        render: function (data, type, row, meta) {
                            return row.credit_tostring;
                        }
                    },
                    {
                        targets: 5,
                        render: function (data, type, row, meta) {
                            return row.categorie.designation;
                        }
                    },
                    {
                        targets: 6,
                        render: function (data, type, row, meta) {
                            return '&nbsp;';
                        }
                    },
                    {
                        targets: -1,
                        width: '60px',
                        render: function (data, type, row, meta) {
                            return '<a href="javascript:void(0)" data-id="' + row.id + '"  class="edit btn btn-success btn-sm" title="Editer"><i class="fas fa-pen"></i></a> <a href="javascript:void(0)" data-id="' + row.id + '" class="delete btn btn-danger btn-sm" title="Supprimer"><i class="fas fa-trash-alt"></i></a>';
                        },
                    }
                ]
            } );
        } );
    </script>
@endsection

