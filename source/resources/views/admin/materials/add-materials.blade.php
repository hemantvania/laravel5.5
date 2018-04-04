@extends("admin.layout.default")

@section('title', __('adminmaterial.title'))

@section("content")

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">

            <h1>
                @lang('adminmaterial.title')
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            @include("error.adminmessage")

            <div class="row">
                <!-- right column -->
                <div class="col-md-6">

                    <!-- general form elements disabled -->
                    <div class="box box-warning">

                        <div class="box-header with-border">
                            <h3 class="box-title">

                                @if(isset($getMaterial))
                                    @if($getMaterial->materialName )
                                        {{$getMaterial->materialName }}
                                    @endif
                                @else
                                    @lang('adminmaterial.addmaterial')
                                @endif


                            </h3>
                        </div>
                        @if(!empty($getMaterial))
                            <form role="form" action="{{ url('admin/materials/'.$getMaterial->id.'/edit') }} " method="post" enctype="multipart/form-data">
                        @else
                            <form role="form" action="{{ url('admin/materials/create') }} " method="post" enctype="multipart/form-data">
                        @endif
                        <!-- /.box-header -->

                        <div class="box-body">


                            {{ csrf_field() }}


                                <div class="form-group {{ $errors->has('materialType') ? ' has-error' : '' }}">

                                    <label>@lang('adminmaterial.type')<em>*</em></label>
                                    <div class="form-group {{ $errors->has('materialType') ? ' has-error' : '' }}">
                                        <select class="form-control " name="materialType" id="materialType">
                                            <option value="">@lang('adminmaterial.type')</option>
                                            <option value="Video" @if(!empty($getMaterial->materialType) && $getMaterial->materialType == "Video") selected="selected" @else @if(!empty(old('materialType')) && old('materialType') == "Video") selected="selected" @endif @endif>@lang('adminmaterial.video')</option>
                                            <option value="Pdf" @if(!empty($getMaterial->materialType) && $getMaterial->materialType == "Pdf") selected="selected" @else @if(!empty(old('materialType')) && old('materialType') == "Pdf") selected="selected" @endif @endif>@lang('adminmaterial.pdf')</option>
                                            <option value="Image" @if(!empty($getMaterial->materialType) && $getMaterial->materialType == "Image") selected="selected" @else @if(!empty(old('materialType')) && old('materialType') == "Image") selected="selected" @endif @endif>@lang('adminmaterial.txt')</option>
                                            <option value="Link" @if(!empty($getMaterial->materialType) && $getMaterial->materialType == "Link") selected="selected" @else @if(!empty(old('materialType')) && old('materialType') == "Link") selected="selected" @endif @endif>@lang('adminmaterial.link')</option>
                                        </select>
                                        @if ($errors->has('materialType'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('materialType') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                </div>




                                <div class="form-group {{ $errors->has('materialName') ? ' has-error' : '' }}">
                                    <label>@lang('adminmaterial.materialname')<em>*</em></label>
                                    <input type="text" class="form-control" name="materialName" value="@if(!empty($getMaterial->materialName)){{$getMaterial->materialName}}@else{{ old('materialName') }}@endif" placeholder="@lang('adminmaterial.materialname')">
                                    @if ($errors->has('materialName'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('materialName') }}</strong>
                                        </span>
                                    @endif
                                </div>




                            <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                                <label>@lang('adminmaterial.description')<em>*</em></label>
                                <textarea name="description" rows="5" cols="42" class="form-control" style="resize: none;">@if(!empty($getMaterial->description)){{$getMaterial->description}}@else{{ old('description') }}@endif</textarea>
                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <input type="hidden" name="categoryId" value="5">



                            {{--
                            <label>@lang('adminmaterial.materialcat')<em>*</em></label>
                            <div class="form-group {{ $errors->has('categoryId') ? ' has-error' : '' }}">
                             <select class="selectpicker" name="categoryId" id="categoryId">
                                  <option value="">@lang('adminmaterial.selectcat')</option>
                                   @if(!empty($materialCategories))
                                       @foreach($materialCategories as $cat)
                                         <option value="{{$cat->id}}"
                                                 @if(!empty($getMaterial->categoryId) && $getMaterial->categoryId == $cat->id)
                                                     selected="selected"
                                                 @else
                                                     @if(!empty(old('categoryId')) && old('categoryId') == $cat->id)
                                                         selected="selected"
                                                     @endif
                                                 @endif
                                         >{{$cat->categoryName}}</option>
                                       @endforeach
                                   @endif
                             </select>
                                 @if ($errors->has('categoryId'))
                                     <span class="help-block">
                                             <strong>{{ $errors->first('categoryId') }}</strong>
                                         </span>
                                 @endif
                             </div>--}}

                            <div id="upload-contents" style="display:@if(!empty($getMaterial->materialType) && $getMaterial->materialType == "Link") none @else @if(!empty(old('materialType')) && old('materialType') == "Link") none  @else  block @endif @endif">
                                <div class="form-group {{ $errors->has('uploadcontent') ? ' has-error' : '' }}">
                                    <label>@lang('adminmaterial.uploadcontent')<em>*</em></label>
                                    <br>
                                    <label class="btn btn-primary btn-file">
                                        <span id="uploadcontent">@lang('adminmaterial.uploadcontent')...</span>
                                        <input id="uploadcontent" type="file" class="form-control" name="uploadcontent" style="display:none;" value="@if(isset($getMaterial->link)) {{ $getMaterial->link }} @endif">
                                    </label>

                                    @if(!empty($getMaterial->link) && $getMaterial->materialType != "Link")
                                        {{--@if($isValid == false)--}}
                                        <input id="current_uploadcontent" type="hidden" name="current_uploadcontent" value="@if(isset($getMaterial->link)) {{ $getMaterial->link }} @endif" >
                                        {{--@endif--}}
                                    @endif

                                    @if ($errors->has('uploadcontent'))
                                        <span class="help-block">
                                              <strong>{{ $errors->first('uploadcontent') }}</strong>
                                          </span>
                                    @endif

                                    @if(!empty($getMaterial->materialType) && $getMaterial->materialType != "Link")
                                        {{--@if($isValid == false)--}}
                                        <a href="{{url($getMaterial->link)}}" target="_blank">@lang('adminmaterial.viewdownload')</a>
                                        {{--@endif--}}
                                    @endif

                                </div>
                            </div>

                            <div id="upload-externalurl" style="display:@if(!empty($getMaterial->materialType) && $getMaterial->materialType == "Link") block @else @if(!empty(old('materialType')) && old('materialType') == "Link") block  @else  none @endif @endif">
                                <div class="form-group {{ $errors->has('link') ? ' has-error' : '' }}">
                                    <label>@lang('adminmaterial.linktitle')</label>
                                    <input type="text" class="form-control" id="thirdPartyLink" value="@if(!empty($getMaterial->materialType) && $getMaterial->materialType == "Link"){{$getMaterial->link}}@else{{old('link')}}@endif" name="link" placeholder="@lang('adminmaterial.linktitle')">
                                    @if ($errors->has('link'))
                                        <span class="help-block">
                                                                <strong>{{ $errors->first('link') }}</strong>
                                                            </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group {{ $errors->has('materialIcon') ? ' has-error' : '' }}">
                                <div class="picture-upload-cust">
                                    @if(!empty($getMaterial->materialIcon))
                                        <img src="{{url($getMaterial->materialIcon)}}" style="max-width: 100%; display: block;" />
                                        <label class="checkbox-inline"><input type="checkbox" name="remove_materialIcon" value="1">@lang('adminmaterial.removeicon')</label>
                                    @else
                                        <img src="{{ asset('img/materiaIcons.png') }}"  style="max-width: 100%; display: block;" />
                                    @endif
                                </div>


                                <div class=" form-group browse-picture-cust">
                                    <label>@lang('adminmaterial.icon')<em>*</em></label>
                                    <br>
                                    <label class="btn btn-primary btn-file">
                                        <span id="materialIcon">@lang('adminmaterial.icon')...</span>
                                        <input id="materialIcon" type="file" class="form-control" name="materialIcon" style="display:none;" >
                                    </label>

                                    @if(!empty($getMaterial->materialIcon))
                                        <input id="current_materialIcon" type="hidden" name="current_materialIcon" value="@if(isset($getMaterial->materialIcon)){{$getMaterial->materialIcon}}@endif" >
                                    @endif

                                    @if ($errors->has('materialIcon'))
                                        <span class="help-block">
                                                            <strong>{{ $errors->first('materialIcon') }}</strong>
                                                        </span>
                                    @endif
                                </div>
                            </div>

                        </div>
                        <!-- /.box-body -->

                            <div class="box-footer">
                                <input type="submit" class="btn btn-primary" value=" @if(!empty($getMaterial)) @lang('general.update') @else @lang('general.add') @endif" name="submit">
                                <a class="btn btn-default" href="{{ url('admin/materials') }}">@lang('general.cancel')</a>
                            </div>

                        </form>

                    </div>
                    <!-- /.box -->
                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection


@section("page-js")
    <script src="{{ asset('assests/admin/material/material-custom.js') }}"></script>
@endsection