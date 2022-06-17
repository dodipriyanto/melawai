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

                <fieldset class="form-group floating-label-form-group">
                    <label for="group">Pegawai</label>
                    <div class="controls">
                        <select class="js-example-basic-single form-control" id="pegawai" name="pegawai_id" style="padding:10px !important;" aria-readonly="true" disabled>
                            <option value="">-- PILIH PEGAWAI --</option>

                            @foreach($employee as $item)
                                <option value="{{$item->id}}">({{$item->nik}}) - {{$item->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                </fieldset>

                <fieldset class="form-group floating-label-form-group">
                    <label for="group">Keluarga</label>
                    <div class="controls">
                        <select class="js-example-basic-single form-control" id="keluarga" name="keluarga_id" style="padding:10px !important;" disabled>
                            <option value="">-- PILIH KELUARGA --</option>

                            @foreach($family as $item)
                                <option value="{{$item->id}}">{{$item->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                </fieldset>

                <fieldset class="form-group floating-label-form-group">
                    <label for="group">Vaksin</label>
                    <div class="controls">
                        <select class="js-example-basic-single form-control" id="vaksin" name="vaksin_id" style="padding:10px !important;">
                            <option value="">-- PILIH VAKSIN --</option>
                            @foreach($vaccine as $item)
                                <option value="{{$item->id}}">{{$item->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                </fieldset>


                <fieldset class='form-group floating-label-form-group'>
                    <label for='dosis'>Dosis Ke</label>
                    <div class='controls'>
                        <input type='text' class='form-control number-only' id='dosis' name='dosis'
                               placeholder='Dosis' required
                               data-validation-required-message='This field is required'>
                    </div>
                </fieldset>
                <fieldset class='form-group floating-label-form-group'>
                    <label for='tanggal_vaksin'>Tanggal Vaksin</label>
                    <div class='controls'>
                        {{--                        <input type='text' class='form-control' id='tanggal_vaksin' name='tanggal_vaksin'--}}
                        {{--                               placeholder='Tanggal Vaksin' required--}}
                        {{--                               data-validation-required-message='This field is required'>--}}
                        <div class="input-group mb-3">
                            <input type="datetime-local" id="tanggal_vaksin" name="tanggal_vaksin" class="form-control dpicker" placeholder="Tanggal Vaksin" aria-label="Recipient's username" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2"><i class="feather icon-calendar" ></i></span>
                            </div>
                        </div>
                    </div>
                </fieldset>
                 

                <div class="modal-footer">
                    <button id="formSubmit" type="submit" class="btn btn-outline-info">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
