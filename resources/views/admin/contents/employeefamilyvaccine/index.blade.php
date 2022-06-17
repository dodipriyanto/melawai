/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/
@extends('admin.layouts.main')
@section('title', 'EmployeeFamilyVaccine')

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
                    <h5>EmployeeFamilyVaccine Table</h5>

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
                                           <th>Nama Pegawai</th>
                                           <th>Nama Keluarga</th>
                                           <th>Status Keluarga</th>
                                           <th>Nama Vaksin</th>
                                           <th>Dosis</th>
                                           <th>Tanggal Vaksin</th>
                                           
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
     @include('admin.contents.employeefamilyvaccine._modal')

@endsection

@section('script')
    <script src="{{asset('lib/flatpickr/js/flatpickr.js')}}"></script>

    <script type="text/javascript">
        var url = {
            detail : "{{route('dashboard_employeefamilyvaccines_detail')}}",
            delete : "{{route('dashboard_employeefamilyvaccines_delete')}}",
            submit : "{{route('dashboard_employeefamilyvaccines_post')}}",
            table : "{{route('dashboard_employeefamilyvaccines_table')}}"
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
                        data: 'family.employee', name: 'family.employee',
                        "render": function (data) {
                            return `<div class="badge ">(${data.nik}) - ${data.nama}</div>`;
                        }
                    },

                    {
                        data: 'family.nama', name: 'family.nama',
                        "render": function (data) {
                            return (data != null ? `<div class="badge badge-success">${data}</div>` : `<div class="badge badge-danger">-</div>`)
                        }
                    },

                    {
                        data: 'family.status_keluarga', name: 'family.status_keluarga',
                        "render": function (data) {
                            return (data != null ? `<div class="badge badge-success">${data}</div>` : `<div class="badge badge-danger">-</div>`)
                        }
                    },

                    // {data: 'dosis', name: 'dosis'},
                    {
                        data: 'vaccine', name: 'vaccine',
                        "render": function (data) {
                            // console.log(data)
                            if(data)
                            {
                                return `<div class="badge badge-success">${data.nama}</div>`;
                            }else{
                                return `<div class="badge badge-danger">BELUM</div>`;

                            }
                        }
                    },

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

                    $('#pegawai').val(response.family.employee.id).trigger('change')
                    $('#keluarga').val(response.family.id).trigger('change')

                    if(response.vaccine)
                    {
                        $('#vaksin').val(response.vaccine.id).trigger('change')
                    }
                    $('#dosis').val(response.dosis)
                    $('#tanggal_vaksin').val(response.tanggal_vaksin)
                    

                });

            });

            $(document).on('click', '.update', function (e) {
                let id = $(this).data('id');
                e.preventDefault();
                formEnableCustom();
                modalShow('myModal','Update Data');

                $.get(url.detail,{id : id}, function (result){
                    let response = result.data;
                    $('#id').val(response.id)
                    $('#pegawai').val(response.family.employee.id).trigger('change')
                    $('#keluarga').val(response.family.id).trigger('change')

                    if(response.vaccine)
                    {
                        $('#vaksin').val(response.vaccine.id).trigger('change')
                    }
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

