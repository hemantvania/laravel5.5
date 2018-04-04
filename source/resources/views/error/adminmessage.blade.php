@if(Session::has('message'))
	        <div class="alert {{ Session::get('class') }} alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{ Session::get('message') }}
              </div>
			  
@endif
