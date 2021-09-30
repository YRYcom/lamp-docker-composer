@extends('layouts.main')
@section('css')

    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('main')



    <table class="table table-bordered operation-datatable">
        <thead>
        <tr>
            <th>#</th>
            <th>Numero Ordre</th>
            <th>Date réalisation</th>
            <th>Réalisation</th>
            <th>Designation</th>
            <th>Debit</th>
            <th>Credit</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>


@endsection

@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

    <script type="text/javascript">

        $(document).ready(function() {
            $('.operation-datatable').DataTable( {
                processing: true,
                serverSide: true,
                ajax: "{{ route('operation.liste') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'numero_ordre', name: 'numero_ordre'},
                    {data: 'date_realisation', name: 'date_realisation'},
                    {data: 'realisation', name: 'realisation'},
                    {data: 'designation', name: 'designation'},
                    {data: 'debit', name: 'debit'},
                    {data: 'credit', name: 'credit'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ]
            } );
        } );

    </script>
@endsection

