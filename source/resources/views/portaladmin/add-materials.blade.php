@extends('layouts.vdesk')
@section("page-css")
@endsection
@section('content')
    @include("error.message")
    <section class="content-wrapper">
        <div class="container-fluid inner-contnet-wrapper">
            <div class="tab-wrapper">
                <div class="row">
                    <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 user-details">@include("comman.admin-nav")</div>
                    @include("comman.navigation")
                 </div>
            </div>

        </div>
    </section>

    <section class="content-wrapper">
        <div class="container-fluid">
                <div class="row">
                        <div class="scroll-main-wrapper2">
                            <div class="col-md-12">
                                <h3 class="box-title">
                                    @if(!empty($getMaterial))
                                        @if(!empty($getMaterial->materialName ))
                                            {{$getMaterial->materialName }}
                                        @endif
                                    @else
                                        @lang('adminmaterial.addmaterial')
                                    @endif
                                </h3>
                            </div>

                            {{--@php
                                $isValid = false;
                                  if(!empty($getMaterial->link)){
                                          if(filter_var($getMaterial->link,FILTER_VALIDATE_URL) === TRUE){
                                                 $isValid = true;
                                          }
                                  }
                            @endphp--}}


                            <form id="material_upload" role="form" action="@if(!empty($getMaterial)){{ url(App::getLocale().'/'. generateUrlPrefix().'/materials/'.$getMaterial->id.'/edit')}}@else{{ url(App::getLocale().'/'. generateUrlPrefix().'/materials/add')}}@endif" method="post" enctype="multipart/form-data">

                                {{ csrf_field() }}
                              <div class="col-lg-3 col-xs-12">
                                  <div class="form-group">
                                      <label>@lang('adminmaterial.type')<em>*</em></label>
                                      <div class="form-group {{ $errors->has('materialType') ? ' has-error' : '' }}">
                                          <select class="selectpicker " name="materialType" id="materialType">
                                              <option value="">@lang('adminmaterial.type')</option>
                                              @foreach ($types as $type)
                                                  <option value="{{$type}}" @if(!empty($getMaterial->materialType) && $getMaterial->materialType == $type ) selected="selected" @else @if(!empty(old('materialType')) && old('materialType') == $type) selected="selected" @endif @endif>{{$type}}</option>
                                              @endforeach
                                          </select>
                                          @if ($errors->has('materialType'))
                                              <span class="help-block">
                                                <strong>{{ $errors->first('materialType') }}</strong>
                                            </span>
                                          @endif
                                      </div>
                                  </div>

                              </div>

                              <div class="col-lg-9 col-xs-12">
                                  <div class="row">
                                      <div class="col-lg-4 col-xs-12">
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
                                                <textarea name="description" rows="5" cols="39">@if(!empty($getMaterial->description)){{$getMaterial->description}}@else{{ old('description') }}@endif</textarea>
                                                @if ($errors->has('description'))
                                                    <span class="help-block">
                                                            <strong>{{ $errors->first('description') }}</strong>
                                                        </span>
                                                @endif
                                            </div>
                                          <div class="form-group {{ $errors->has('default_language') ? ' has-error' : '' }}">
                                              <label>@lang('general.select_language')<em>*</em></label>
                                              <select id="default_language" class="selectpicker" name="default_language">
                                                  <option value="">@lang('general.select_language')</option>
                                                  @if(config('language.option'))
                                                      @foreach(config('language.option') as $key=>$value)
                                                          <option value="{{$key}}" @if(old('default_language') == $key) selected @endif @if(!empty($getMaterial->language) && $getMaterial->language == $key) selected @endif>{{$value}}</option>
                                                      @endforeach
                                                  @endif
                                              </select>
                                              @if ($errors->has('default_language'))
                                                  <span class="help-block">
                                                    <strong>{{ $errors->first('default_language') }}</strong>
                                                  </span>
                                              @endif
                                          </div>
                                            <div>
                                                <div class="form-group">
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
                                                </div>
                                            </div>
                                            </div>
                                      <div class="col-lg-4 col-xs-12">
                                          <div id="upload-contents" style="display:@if(!empty($getMaterial->materialType) && $getMaterial->materialType == "Link") none @else @if(!empty(old('materialType')) && old('materialType') == "Link") none  @else  block @endif @endif">
                                              <div class="form-group {{ $errors->has('uploadcontent') ? ' has-error' : '' }}">

                                                  <label>@lang('teacher.upload_file')<em>*</em></label><br>
                                                  <label class="btn btn-vdesk btn-file">
                                                      <span id="uploadcontent">@lang('adminmaterial.uploadcontent')...</span>
                                                      <input onChange="showSelectedFileName(this)" id="uploadcontent" type="file" class="form-control" name="uploadcontent" style="display:none;" value="@if(isset($getMaterial->link)) {{ $getMaterial->link }} @endif">
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
                                                  <p>
                                                      <a href="{{url($getMaterial->link)}}" target="_blank">@lang('adminmaterial.viewdownload')</a>
                                                  </p>
                                                      {{--@endif--}}
                                                  @endif

                                              </div>
                                          </div>
                                            <div class="form-group" id="upload-externalurl" style="display:@if(!empty($getMaterial->materialType) && $getMaterial->materialType == "Link") block @else @if(!empty(old('materialType')) && old('materialType') == "Link") block  @else  none @endif @endif">
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
                                              <div class="form-group">
                                                  <br><br>
                                                  <div class="form-group pull-left {{ $errors->has('materialIcon') ? ' has-error' : '' }}">
                                                      <div class="picture-upload-cust">
                                                          @if(!empty($getMaterial->materialIcon))
                                                              <img src="{{url($getMaterial->materialIcon)}}" style="max-width: 100%; display: block;" />
                                                              <label class="checkbox-inline"><input type="checkbox" name="remove_materialIcon" value="1">@lang('adminmaterial.removeicon')</label>
                                                          @else
                                                              <img src="{{ asset('img/materiaIcons-small.png') }}"  style="max-width: 100%; display: block;" />
                                                          @endif
                                                      </div>
                                                      <div class="browse-picture-cust">
                                                          <label class="btn btn-vdesk btn-file">
                                                              <span id="materialIcon">@lang('adminmaterial.icon')...</span>
                                                              <input onChange="showSelectedFileName(this)" id="materialIcon" type="file" class="form-control" name="materialIcon" style="display:none;" >
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
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="col-lg-12 col-xs-12">
                                          <div class="form-group">
                                              <button type="submit" name="submit" class="btn btn-vdesk">@if(!empty($getMaterial)) @lang('general.update') @else @lang('general.add') @endif</button>
                                              <a class="btn btn-default btn-vdesk-light" href="{{ url(App::getLocale().'/'. generateUrlPrefix().'/materials') }}">@lang('general.cancel')</a>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
    <script src="{{ url('js/material/material-custom.js')}}"></script>
@endsection
