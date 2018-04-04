@extends("admin.layout.default")

@section('title', __('adminmaerialcat.title'))

@section("page-css")
    <link rel="stylesheet" href="{{ asset('assests/admin/material/dynatree/skin/ui.dynatree.css') }}">
@endsection

@section("content")
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
		
            <h1>
                @lang('adminmaerialcat.title')
            </h1>

		</section>

        <!-- Main content -->
        <section class="content">

            @include("error.adminmessage")

            <div class="row">
                 <div class="col-xs-12">
                     <div class="box">
                         <div class="box-header">
                             <h3 class="box-title">@lang('adminmaerialcat.title')</h3>
                         </div>
                         <!-- /.box-header -->
                         <div class="box-body">
							<div class="row">
								<div class="col-sm-4">
                                    <div id="tree">
                                        @php
                                           // $getSubcategory = new MaterialsCategoriesController();
                                        @endphp
                                        <ul>
                                            @if(!empty($catList))

                                                @foreach($catList as $list)

                                                    <li data-id="{{$list->id}}" title="{{$list->id}}">{{$list->categoryName}}

                                                     @php
                                                       $subCategory = App\Http\Controllers\Admin\MaterialsCategoriesController::getChildCategory($list->id);
                                                     @endphp

                                                        @if(!empty($subCategory))

                                                            <ul>
                                                                @foreach($subCategory as $sub)

                                                                    <li data-id="{{$sub->id}}" title="{{$sub->id}}">{{$sub->categoryName}}

                                                                    @php
                                                                        $levelThree = App\Http\Controllers\Admin\MaterialsCategoriesController::getChildCategory($sub->id);
                                                                    @endphp

                                                                    @if(!empty($levelThree))

                                                                        <ul>

                                                                        @foreach($levelThree as $three)

                                                                            <li data-id="{{$three->id}}" title="{{$three->id}}">{{$three->categoryName}}</li>

                                                                            @endforeach

                                                                            <li data-rel="0" data-id="{{$sub->id}}" title="{{$sub->id}}">@lang('adminmaerialcat.addnew')</li>

                                                                        </ul>

                                                                    @endif

                                                                    </li>

                                                             @endforeach
                                                                    <li data-rel="0" data-id="{{$list->id}}" title="{{$list->id}}">@lang('adminmaerialcat.addnew')</li>
                                                            </ul>

                                                         @endif
                                                    </li>

                                                @endforeach


                                            @else

                                            @endif

                                                <li data-id="0" data-rel="0" title="0">@lang('adminmaerialcat.addnew')</li>

                                        </ul>
                                        {{--<a href="javascript:void(0)"  data-id="0" data-remote="false" data-toggle="modal" data-target="#myModal" id="add-new-category">
                                            @lang('adminmaerialcat.addnew')
                                        </a>--}}
                                    </div>
                                        {{-- <div>Active node: <span id="echoActive">-</span></div>--}}

 </div>


</div>
<!-- /.box-body -->
</div>
<!-- /.box -->
</div>
</div>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">

<div class="modal-content load_modal"></div>

</div>
</div>
@endsection


@section("page-js")


<script src="{{ asset('assests/admin/material/dynatree/jquery/jquery-ui.custom.js') }}" type="text/javascript"></script>


<script src="{{ asset('assests/admin/material/dynatree/jquery.dynatree.js') }}"></script>
<script src="{{ asset('assests/admin/material/material-cat.js') }}"></script>

@endsection