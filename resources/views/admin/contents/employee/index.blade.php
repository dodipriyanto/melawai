/**
* @author Dodi Priyanto<dodi.priyanto76@gmail.com>
*/
@extends('admin.layouts.main')
@section('title', 'Employee')

@section('stylesheet')
    <link rel="stylesheet" type="text/css" href="{{asset('lib/flatpickr/css/flatpickr.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('lib/bootstrap-fileinput/css/fileinput.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('lib/font-awesome/css/font-awesome.min.css')}}">
    <link href="{{asset('lib/bootstrap-toggle/bootstrap-toggle.min.css')}}" rel="stylesheet">
    <style>
        .toggle-on,  .toggle-off{
            padding: 7px 15px 5px 15px !important;
            font-weight: bold !important;
        }


        .toggle-on{
            background: #1dd5d2 !important;
            border: #1dd5d2 !important;
            color: #FFFFFF !important;
        }

        .toggle-off{
            background: #f44236 !important;
            border: #f44236 !important;
            color: #FFFFFF !important;
        }
    </style>
@endsection

@section('breadcumbs')
    @include('admin.templates.breadcrumbs2')
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Employee Table</h5>

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
                                           <th>Umur</th>
                                           <th>Alamat</th>
                                           <th>Nomor Telpon</th>
                                           <th>Tanggal Lahir</th>
                                           <th>Tempat Lahir</th>
                                           <th>Sudah Berkerluarga?</th>
                                           <th>Pas Foto</th>

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
     @include('admin.contents.employee._modal')

@endsection

@section('script')
    <script src="{{asset('lib/flatpickr/js/flatpickr.js')}}"></script>
    <script src="{{asset('lib/bootstrap-fileinput/js/fileinput.js')}}"></script>
    <script src="{{asset('lib/fa-theme/theme.js')}}"></script>
    <script src="{{asset('lib/bootstrap-toggle/bootstrap-toggle.min.js')}}"></script>

    <script type="text/javascript">
        var url = {
            detail : "{{route('dashboard_employees_detail')}}",
            delete : "{{route('dashboard_employees_delete')}}",
            submit : "{{route('dashboard_employees_post')}}",
            table : "{{route('dashboard_employees_table')}}"
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
                    {data: 'nama', name: 'nama'},
                    {data: 'umur', name: 'umur'},
                    {data: 'alamat', name: 'alamat'},
                    {data: 'nomor_telpon', name: 'nomor_telpon'},
                    {data: 'tanggal_lahir', name: 'tanggal_lahir'},
                    {data: 'tempat_lahir', name: 'tempat_lahir'},

                    {
                        data: 'is_have_family', name: 'is_have_family',
                        "render": function (data) {
                            // console.log(data)
                            return (data === 1 ? `<div class="badge badge-success">SUDAH</div>` : `<div class="badge badge-danger">BELUM</div>`)
                        }
                    },
                    {data: "file_upload", className: 'dt-center',
                        "render": function (data, type, row) {
                            let img = "{{asset('storage/images/')}}"+'/'+`${data}`;
                            return `<img src="${img}" class="img-thumbnail img-responsive" style="max-width: 150px; max-height: 150px" />`;
                        }
                    },
                    
                    {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center',width: '15%'},
                ]
            });


            $(document).on('change','.cb', function (e){
                if($(this).prop("checked")){
                    $(this).val('1');
                } else {
                    $(this).val('0');
                }
            })

            $(document).on('click', '.view', function (e) {
                let id = $(this).data('id');
                e.preventDefault();
                formDisable();
                modalShow('myModal','View Data');
                $.get(url.detail, {id : id}, function (result){

                    let response = result.data;

                    console.log(result)
                    $('#nama').val(response.nama)
                    $('#umur').val(response.umur)
                    $('#alamat').val(response.alamat)
                    $('#nomor_telpon').val(response.nomor_telpon)
                    $('#tanggal_lahir').val(response.tanggal_lahir)
                    $('#tempat_lahir').val(response.tempat_lahir)
                    // $('#is_have_family').val(response.is_have_family)

                    toogleLogic(response.is_have_family)
                    makeInput(response.file_upload)
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
                    $('#umur').val(response.umur)
                    $('#alamat').val(response.alamat)
                    $('#nomor_telpon').val(response.nomor_telpon)
                    $('#tanggal_lahir').val(response.tanggal_lahir)
                    $('#tempat_lahir').val(response.tempat_lahir)
                    $('#is_have_family').val(response.is_have_family)

                    toogleLogic(response.is_have_family)
                    makeInput(response.file_upload)
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
                    umur: {
                        required: true,
                    },
                    alamat: {
                        required: true,
                    },
                    nomor_telpon: {
                        required: true,
                    },
                    tanggal_lahir: {
                        required: true,
                    },
                    tempat_lahir: {
                        required: true,
                    },
                    is_have_family: {
                        required: true,
                    },
                    

                },
                submitHandler: function (form) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': CSRF_TOKEN
                        }
                    });
                    let id = $('#id').val();


                    let file_data = $('#fileUpload').prop('files')[0],
                        form_data = new FormData(document.getElementById('formModal'));

                    console.log(file_data);

                    form_data.append('_token' , $("input[name=_token]").val());
                    // form_data.append('_cache_id' , localStorage.getItem('cache_id'));
                    form_data.append('file_upload', file_data);
                    form_data.append('id', id);


                    $.ajax({
                        url: url.submit,
                        data: form_data,
                        type: 'POST',
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            swalStatus(response,"myModal")

                        }

                    });
                    event.preventDefault();
                }
            });

            $('.addModal').on('click', function () {
                resetFileInput();
                makeInput();
                formReset();
                // resetEditor();
                // visible_size_div();

                modalShow('myModal', 'Add Data');
            });

        });


        function toogleLogic(param)
        {
            if(param === 1){
                $('.cb').bootstrapToggle('on')
                $('.cb').prop("checked",'checked')
            }else{
                $('.cb').bootstrapToggle('off')
            }
        }

        function resetFileInput() {
            $('#fileUpload').fileinput('destroy');
        }
        function makeInput(value) {
            $('#fileUpload').fileinput('destroy');

            if (value) {
                let url = "{{asset('storage/images')}}" + '/' + `${value}`
                let filename = value.split('/')[1];
                $("#fileUpload").fileinput({
                    'showUpload': false,
                    theme: 'fa',
                    showClose: false,
                    showMove: false,
                    initialPreviewConfig: [
                        {caption: `${filename}`, downloadUrl: url, key: 1}
                    ],
                    initialPreview: url,
                    initialPreviewAsData: true,
                    layoutTemplates: {
                        progress: '',
                        remove: ''
                    },
                    allowedFileExtensions: ['jpg', 'gif', 'png','pdf','xls','xlsx'],
                    initialPreviewShowDelete: false,
                    {{--deleteUrl: '{{route('file_delete')}}',--}}
                    elErrorContainer: '#kartik-file-errors',
                });

                $(".glyphicon").removeClass("glyphicon-download").removeClass('glyphicon').addClass('fa fa-download');

            } else {
                $("#fileUpload").fileinput({
                    'showUpload': false,
                    theme: 'fa',
                    'previewFileType': 'any',
                    fileActionSettings: {
                        showDrag: false,
                    },
                    allowedFileExtensions: ['jpg', 'gif', 'png','pdf','xls','xlsx'],
                    initialPreviewAsData: true,
                    layoutTemplates: {
                        progress: '',
                        remove: ''
                    },
                    initialPreviewShowDelete: true,
                    deleteUrl: '{{route('file_delete')}}',
                    elErrorContainer: '#kartik-file-errors',
                });

                var uploadField = document.getElementById("fileUpload");

                //set max file 5mb
                uploadField.onchange = function() {
                    if(this.files[0].size > 5000000){
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'File terlalu besar! Maksimum ukuran file 5MB'
                        })

                        $('#fileUpload').fileinput('destroy');
                        $("#fileUpload").val(null);
                        makeInput();

                    };
                };
            }
        }

    </script>


@endsection

