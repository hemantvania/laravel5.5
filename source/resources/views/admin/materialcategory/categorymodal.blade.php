
<div class="modal-content">
	<div class="modal-header">
		<h3 class="box-title">
			@lang('adminmaerialcat.addnew')
		</h3>
	</div>
	<form role="form" action="" method="post">
		<div class="modal-body">
		
			{{ csrf_field() }}
			 <input type="hidden" class="form-control" name="parentcat" id="parentcat" value="{{$id}}" placeholder="">
			<div class="form-group">
				<label>@lang('adminmaerialcat.catname')</label>
				<input type="text" class="form-control" name="catname" id="catname" value="" placeholder="@lang('adminmaerialcat.catname')">
			</div>
		</div>
		<div class="modal-footer">
			<input type="submit" class="btn btn-primary" id="add-material-cat" value="@lang('general.add')" name="submit">
			<a href="javascript:void(0);" class="btn btn-default" id="close-cat-modal">@lang('general.cancel')</a>
		</div>
	</form>
</div>
	