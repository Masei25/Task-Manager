
@if(session('success'))

    <div class="alert text-white bg-success" role="alert">
        <div class="iq-alert-icon">
            <i class="ri-checkbox-circle-fill"></i>
        </div>
        <div class="iq-alert-text">{{session('success')}}!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button></div>
    </div>

@endif

@if(session('error'))

    <div class="alert text-white bg-danger" role="alert">
        <div class="iq-alert-icon">
            <i class="ri-close-circle-fill"></i>
        </div>
        <div class="iq-alert-text">{{session('error')}}!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>

@endif









