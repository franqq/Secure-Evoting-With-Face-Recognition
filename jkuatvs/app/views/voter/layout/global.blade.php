@if(Session::has('globalerror'))
	 <div class="alert alert-danger alert-dismissable">
        <i class="fa fa-ban"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <b>Error!</b> {{Session::get('globalerror')}}.
    </div>
@endif
@if(Session::has('globalsuccess'))
    <div class="alert alert-success alert-dismissable">
        <i class="fa fa-check"></i>
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <b>Success!</b> {{Session::get('globalsuccess')}}.
    </div>
@endif