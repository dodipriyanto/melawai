/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/
@extends('admin.layouts.main')
@section('title', 'MonitoringCovid')

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
                    <h5>MonitoringCovid Table</h5>

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
                                           <th>Nama</th>
                                           <th>Deskripsi</th>
                                           <th>Satuan</th>
                                           
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
     @include('admin.contents.monitoringcovid._modal')

@endsection

@section('script')

    <script type="text/javascript">
        var url = {
            detail : "{{route('dashboard_monitoringcovids_detail')}}",
            delete : "{{route('dashboard_monitoringcovids_delete')}}",
            submit : "{{route('dashboard_monitoringcovids_post')}}",
            table : "{{route('dashboard_monitoringcovids_table')}}"
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
                    {data: 'nama', name: 'nama'},
                    {data: 'deskripsi', name: 'deskripsi'},
                    {data: 'satuan', name: 'satuan'},
                    
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
                    $('#nama').val(response.nama)
                    $('#deskripsi').val(response.deskripsi)
                    $('#satuan').val(response.satuan)
                    

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
                    $('#nama').val(response.nama)
                    $('#deskripsi').val(response.deskripsi)
                    $('#satuan').val(response.satuan)
                    

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
                    nama: {
                        required: true,
                    },
                    deskripsi: {
                        required: true,
                    },
                    satuan: {
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

