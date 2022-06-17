<!-- Modal -->

<div class="md-modal md-effect-1" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModal" style=" height: 80% !important;" >

    <div class="md-content">
        <h3 class="theme-bg2 modal-title">Modal Dialog</h3>
        <button type="button" class="close  md-close" data-dismiss="modal" aria-label="Close" style="margin-top: -4em">
            <span aria-hidden="true" style="font-size: 2rem; padding: 10px;" class="text-white">&times;</span>
        </button>
        <div>
            <form class="form-horizontal" method="POST" id="formModal"
                  novalidate>
                @csrf
                <input type="hidden" name="id" id="id" class="id">

                <fieldset class='form-group floating-label-form-group'>
                    <label for='employe_covid_id'>Pegawai Covid</label>

                    <div class="controls">
                        <select class="js-example-basic-single form-control" id="employe_covid_id" name="employe_covid_id" style="padding:10px !important;">
                            <option value="">-- PILIH PEGAWAI COVID--</option>
                            @foreach($employee_covid as $item)
                                <option value="{{$item->id}}">({{$item->employee->nik}}) - {{$item->employee->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                </fieldset>
                <fieldset class='form-group floating-label-form-group'>
                    <label for='tanggal_pengecekan'>Tanggal Pengecekan</label>
                    <div class='controls'>

                        <div class="input-group mb-3">
                            <input type="datetime-local" id="tanggal_pengecekan" name="tanggal_pengecekan" class="form-control dpicker" placeholder="Tanggal Pengecekan" aria-label="Recipient's username" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2"><i class="feather icon-calendar" ></i></span>
                            </div>
                        </div>
                    </div>
                </fieldset>
                 <fieldset class='form-group floating-label-form-group'>
                    <label for='metode_pengecekan_id'>Metode Pengecekan</label>

                     <div class="controls">
                         <select class="js-example-basic-single form-control" id="metode_pengecekan_id" name="metode_pengecekan_id" style="padding:10px !important;" >
                             <option value="">-- PILIH METODE PEBGECEKAN--</option>

                             @foreach($monitoring as $item)
                                 <option value="{{$item->id}}">{{$item->nama}} - ({{$item->satuan}})</option>
                             @endforeach
                         </select>
                     </div>
                </fieldset>

                 <fieldset class='form-group floating-label-form-group'>
                    <label for='nilai'>Nilai</label>
                    <div class='controls'>
                        <input type='text' class='form-control' id='nilai' name='nilai'
                               placeholder='Nilai' required
                               data-validation-required-message='This field is required'>
                    </div>
                </fieldset>
                 

                <div class="modal-footer">
                    <button id="formSubmit" type="submit" class="btn btn-outline-info">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
