/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/
@extends('admin.layouts.main')
@section('title', 'EmployeeVaccine')

@section('stylesheet')

@endsection

@section('breadcumbs')
    @include('admin.templates.breadcrumbs2')
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>EmployeeVaccine Table</h5>

                </div>
                <div class="card-block">
                     @php
                          $current_path = \Request::route()->getName();
                          getPagesAccess($current_path);
                     @endphp
                     <div class="table-responsive">
                           <div class="wrap-table100">
                               <div class="table100">
                                   <table id="contentTable" class="display table nowrap table-striped table-hover" style="width:100%">
                                       <thead>
                                       <tr class="table100-head">
                                           <th width="3%" class="text-center">No</th>
                                           <th>Pegawai_id</th>
                                           <th>Vaksin_id</th>
                                           <th>Dosis</th>
                                           <th>Tanggal_vaksin</th>
                                           
                                           <th class="text-center">Action</th>
                                       </tr>
                                       </thead>
                                       <tbody>
                                       </tbody>
                                   </table>
                               </div>
                           </div>
                     </div>
                </div>
            </div>
        </div>


    </div>
     @include('admin.contents.employeevaccine._modal')

@endsection

@section('script')

    <script type="text/javascript">
        var url = {
            detail : "{{route('dashboard_employeevaccines_detail')}}",
            delete : "{{route('dashboard_employeevaccines_delete')}}",
            submit : "{{route('dashboard_employeevaccines_post')}}",
            table : "{{route('dashboard_employeevaccines_table')}}"
        };
        var table;


        $(document).ready(function () {
            var CSRF_TOKEN = "{{@csrf_token()}}";
            table = $('#contentTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: url.table,
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', title: '#', width: '2%'},
                    {data: 'pegawai_id', name: 'pegawai_id'},
                    {data: 'vaksin_id', name: 'vaksin_id'},
                    {data: 'dosis', name: 'dosis'},
                    {data: 'tanggal_vaksin', name: 'tanggal_vaksin'},
                    
                    {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center',width: '15%'},
                ]
            });

            $(document).on('click', '.view', function (e) {
                let id = $(this).data('id');
                e.preventDefault();
                formDisable();
                modalShow('myModal','View Data');
                $.get(url.detail, {id : id}, function (result){

                    let response = result.data;
                    $('#pegawai_id').val(response.pegawai_id)
                    $('#vaksin_id').val(response.vaksin_id)
                    $('#dosis').val(response.dosis)
                    $('#tanggal_vaksin').val(response.tanggal_vaksin)
                    

                });

            });

            $(document).on('click', '.update', function (e) {
                let id = $(this).data('id');
                e.preventDefault();
                formEnable();
                modalShow('myModal','Update Data');

                $.get(url.detail,{id : id}, function (result){
                    let response = result.data;
                    $('#id').val(response.id)
                    $('#pegawai_id').val(response.pegawai_id)
                    $('#vaksin_id').val(response.vaksin_id)
                    $('#dosis').val(response.dosis)
                    $('#tanggal_vaksin').val(response.tanggal_vaksin)
                    

                });

            });
            $(document).on('click', '.delete', function (e) {
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    }
                });

                swal({
                    title: `Are you sure delete ${$(this).data('name')}?`,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((confirm) => {
                        if (confirm) {
                            $.ajax({
                                url: url.delete,
                                method: 'GET',
                                data: {
                                    id: $(this).data('id'),
                                },
                            })
                                .then((result) => {
                                    swalStatus(result,"myModal")
                                }).then(() => {
                                tableReload(table)
                            });
                        }
                        // else {
                        //     swal("Your imaginary file is safe!");
                        // }
                    });


            });

            $('#formModal').validate({ // initialize the plugin
                rules: {
                    pegawai_id: {
                        required: true,
                    },
                    vaksin_id: {
                        required: true,
                    },
                    dosis: {
                        required: true,
                    },
                    tanggal_vaksin: {
                        required: true,
                    },
                    

                },
                submitHandler: function (form) {
                    let data = $('#formModal').serialize();

                    $.post(url.submit, data, function (result) {
                        swalStatus(result,"myModal")
                    });
                }
            });

        });
    </script>


@endsection
