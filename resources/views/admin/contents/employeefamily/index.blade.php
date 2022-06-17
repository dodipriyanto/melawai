/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/
@extends('admin.layouts.main')
@section('title', 'EmployeeFamily')

@section('stylesheet')
    <link rel="stylesheet" type="text/css" href="{{asset('lib/flatpickr/css/flatpickr.min.css')}}">

@endsection

@section('breadcumbs')
    @include('admin.templates.breadcrumbs2')
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>EmployeeFamily Table</h5>

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
                                           <th>Pegawai</th>
                                           <th>Nama</th>
                                           <th>Status Keluarga</th>
                                           <th>Umur</th>
                                           <th>Tempat Lahir</th>
                                           <th>Tanggal Lahir</th>
                                           <th>Nomor Telpon</th>
                                           
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
     @include('admin.contents.employeefamily._modal')

@endsection

@section('script')
    <script src="{{asset('lib/flatpickr/js/flatpickr.js')}}"></script>

    <script type="text/javascript">
        var url = {
            detail : "{{route('dashboard_employeefamilies_detail')}}",
            delete : "{{route('dashboard_employeefamilies_delete')}}",
            submit : "{{route('dashboard_employeefamilies_post')}}",
            table : "{{route('dashboard_employeefamilies_table')}}"
        };
        var table;


        $(document).ready(function () {
            var CSRF_TOKEN = "{{@csrf_token()}}";
            $(".dpicker").flatpickr({enableTime: false, dateFormat: "Y-m-d"});

            table = $('#contentTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: url.table,
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', title: '#', width: '2%'},

                    {
                        data: 'employee', name: 'employee',
                        "render": function (data) {
                            // console.log(data)
                            return `<div class="badge ">(${data.nik}) - ${data.nama}</div>`;
                        }
                    },
                    {data: 'nama', name: 'nama'},
                    {data: 'status_keluarga', name: 'status_keluarga'},
                    {data: 'umur', name: 'umur'},
                    {data: 'tempat_lahir', name: 'tempat_lahir'},
                    {data: 'tanggal_lahir', name: 'tanggal_lahir'},
                    {data: 'nomor_telpon', name: 'nomor_telpon'},
                    
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
                    $('#pegawai').val(response.employee.id).trigger('change')
                    $('#status_keluarga').val(response.status_keluarga).trigger('change')
                    $('#nama').val(response.nama)
                    $('#umur').val(response.umur)
                    $('#tempat_lahir').val(response.tempat_lahir)
                    $('#tanggal_lahir').val(response.tanggal_lahir)
                    $('#nomor_telpon').val(response.nomor_telpon)
                    

                });

            });

            $(document).on('click', '.update', function (e) {
                let id = $(this).data('id');
                e.preventDefault();
                formEnable();
                modalShow('myModal','Update Data');

                $.get(url.detail,{id : id}, function (result){
                    let response = result.data;

                    console.log(response);
                    $('#id').val(response.id)

                    $('#pegawai').val(response.employee.id).trigger('change')
                    $('#status_keluarga').val(response.status_keluarga).trigger('change')
                    $('#nama').val(response.nama)
                    $('#umur').val(response.umur)
                    $('#tempat_lahir').val(response.tempat_lahir)
                    $('#tanggal_lahir').val(response.tanggal_lahir)
                    $('#nomor_telpon').val(response.nomor_telpon)
                    

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
                    status_keluarga: {
                        required: true,
                    },
                    nama: {
                        required: true,
                    },
                    umur: {
                        required: true,
                    },
                    tempat_lahir: {
                        required: true,
                    },
                    tanggal_lahir: {
                        required: true,
                    },
                    nomor_telpon: {
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

