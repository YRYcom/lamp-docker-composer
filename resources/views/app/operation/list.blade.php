@extends('layouts.main')

@section('titleName', 'Opération')

@section('css')
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('main')

    <section class="content">

    <div class="card card-outline">
        <div class="card-header">
            Liste des opérations
            <div class="card-tools">
                <a href="{{ route('operation.creer') }}" class="btn btn-primary"><i class="fas fa-plus mr-2"></i>Ajouter</a>
            </div>
        </div>
        <div class="card-body">
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

            $('.operation-datatable').on('click', '.edit', function(e) {
                window.location.href = urlEditer.replace('idOperation', $(this).data('id'));
            });

            $('.operation-datatable').DataTable( {
                processing: true,
                serverSide: true,
                ajax: "{{ route('operation.liste') }}",
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
                        render: function (data, type, row, meta) {
                            return row.debit;
                        }
                    },
                    {
                        targets: 4,
                        render: function (data, type, row, meta) {
                            return row.credit;
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

