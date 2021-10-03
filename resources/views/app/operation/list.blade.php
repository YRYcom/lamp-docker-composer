@extends('layouts.main')

@section('titleName',  $compteBancaire->entreprise->designation . ' - Compte bancaire  : ' . $compteBancaire->designation  )

@section('css')
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
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
                <a href="{{ route('operation.creer', ['compte_bancaire_id' => $compteBancaire->id]) }}" class="btn btn-primary"><i class="fas fa-plus mr-2"></i>Ajouter</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-2 offset-md-3">
                    <div class="form-group row">
                        <label for="avec_piece" class="col-sm-8 col-form-label text-right">Avec pièce</label>
                        <div class="col-sm-4">
                        <select name="avec_piece" id="avec_piece" class="form-control  custom-select @error('categorie_id') is-invalid @enderror">
                            <option>Tous</option>
                            <option value="oui">Oui</option>
                            <option value="nons">Non</option>
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
                    <th>Pointé</th>
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
                            return row.id;
                        },
                    },
                    {
                        targets: 1,
                        render: function (data, type, row, meta) {
                            if(row.date_realisation === null) {
                                row.date_realisation_tostring = '';
                            } else {
                                row.date_realisation_tostring = ' - ' +row.date_realisation;
                            }
                            if(row.pointe){
                                return `<span class="badge badge-success">Oui` + row.date_realisation_tostring + `</span>`;
                            } else {
                                return `<span class="badge badge-danger"> Non` + row.date_realisation_tostring + `</span>`;
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

