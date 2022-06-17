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
                    <label for='pegawai_id'>Pegawai_id</label>
                    <div class='controls'>
                        <input type='text' class='form-control' id='pegawai_id' name='pegawai_id'
                               placeholder='Pegawai_id' required
                               data-validation-required-message='This field is required'>
                    </div>
                </fieldset>
                 <fieldset class='form-group floating-label-form-group'>
                    <label for='vaksin_id'>Vaksin_id</label>
                    <div class='controls'>
                        <input type='text' class='form-control' id='vaksin_id' name='vaksin_id'
                               placeholder='Vaksin_id' required
                               data-validation-required-message='This field is required'>
                    </div>
                </fieldset>
                 <fieldset class='form-group floating-label-form-group'>
                    <label for='dosis'>Dosis</label>
                    <div class='controls'>
                        <input type='text' class='form-control' id='dosis' name='dosis'
                               placeholder='Dosis' required
                               data-validation-required-message='This field is required'>
                    </div>
                </fieldset>
                 <fieldset class='form-group floating-label-form-group'>
                    <label for='tanggal_vaksin'>Tanggal_vaksin</label>
                    <div class='controls'>
                        <input type='text' class='form-control' id='tanggal_vaksin' name='tanggal_vaksin'
                               placeholder='Tanggal_vaksin' required
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
