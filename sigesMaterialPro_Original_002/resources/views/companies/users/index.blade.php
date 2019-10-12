@extends('templates.material.main')

@section('content')

@push('after-scripts')
    <!-- This is data table -->
    <script src="/vendor/wrappixel/material-pro/4.2.1/assets/plugins/datatables/datatables.min.js"></script>
    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <!-- end - This is for export functionality only -->
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
            $(document).ready(function() {
                var table = $('#example').DataTable({
                    "columnDefs": [{
                        "visible": false,
                        "targets": 2
                    }],
                    "order": [
                        [2, 'asc']
                    ],
                    "displayLength": 25,
                    "drawCallback": function(settings) {
                        var api = this.api();
                        var rows = api.rows({
                            page: 'current'
                        }).nodes();
                        var last = null;
                        api.column(2, {
                            page: 'current'
                        }).data().each(function(group, i) {
                            if (last !== group) {
                                $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                                last = group;
                            }
                        });
                    }
                });
                // Order by the grouping
                $('#example23 tbody').on('click', 'tr.group', function() {
                    var currentOrder = table.order()[0];
                    if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                        table.order([2, 'desc']).draw();
                    } else {
                        table.order([2, 'asc']).draw();
                    }
                });
            });
        });
        $('#example23').DataTable({
            select: true,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend:    'copyHtml5',
                    text:      '<i class="mdi mdi-content-copy"></i>',
                    titleAttr: 'Copy'
                },
                {
                    extend:    'csvHtml5',
                    text:      '<i class="mdi mdi-view-sequential"></i>',
                    titleAttr: 'CSV'
                },
                {
                    extend:    'excelHtml5',
                    text:      '<i class="mdi mdi-file-excel"></i>',
                    titleAttr: 'Excel'
                },
                {
                    extend:    'pdfHtml5',
                    text:      '<i class="mdi mdi-file-pdf"></i>',
                    titleAttr: 'PDF'
                },
                {
                    extend: 'print',
                    text: '<i class="mdi mdi-printer"></i>',
                    titleAttr: 'Print'
                }
            ]
        });
    </script>
@endpush

<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-themecolor">
                    Empresas
                    <a href="" type="button" class="btn btn-sm btn-secondary btn-circle" data-toggle="tooltip" title="Nova"><i class="fa fa-check"></i></a>
                </h3>
                <div class="card-subtitle">
                    Listagem de empresas cadastradas
                </div>
                <div class="table-responsive m-t-40">
                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr class="text-themecolor">
                                <th>Name</th>
                                <th>EIN/SSA</th>
                                <th>Office</th>
                                <th>Age</th>
                                <th>Start date</th>
                                <th>Salary</th>
                            </tr>
                        </thead>
                        <tfoot>
                        </tfoot>
                        <tbody>
                            @foreach($companyUsers as $companyUser)
                                <tr>
                                    <td>
                                        <a href="{{ route('tenant.switch', $companyUser->company_id) }}" class="link" data-toggle="tooltip" title="Entrar"><i class="mdi mdi-arrow-right-bold"></i></a>
                                        {{ $companyUser->company->name }}
                                    </td>
                                    <td>{{ $companyUser->company->einssa }}</td>
                                    <td>Edinburgh</td>
                                    <td>61</td>
                                    <td>2011/04/25</td>
                                    <td>$320,800</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- End PAge Content -->
<!-- ============================================================== -->
@endsection