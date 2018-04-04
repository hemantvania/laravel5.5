<div class="pulpetit-main">
    <div class="row">
            <div class="col-md-12">
                <h3 class="box-title">
                    @if(isset($getMaterial))
                        @if(!empty($getMaterial->materialName ))
                            {{$getMaterial->materialName }}
                        @endif
                    @else
                        @lang('adminmaterial.addmaterial')
                    @endif
                </h3>
            </div>

                <form role="form" @if(isset($getMaterial)) action="{{ generateLangugeUrl(App::getLocale(),url('teacher/contents/'.$getMaterial->id.'/edit'))}}" @else action="{{ generateLangugeUrl(App::getLocale(),url('teacher/contents/add'))}}" @endif method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="col-lg-3 col-xs-12">
                    <div class="form-group">
                        <label>@lang('adminmaterial.type')<em>*</em></label>
                        <div class="form-group {{ $errors->has('materialType') ? ' has-error' : '' }}">
                            <select class="selectpicker " name="materialType" id="materialType">
                                <option value="">@lang('adminmaterial.type')</option>
                                <option value="Video"
                                        @if(!empty($getMaterial->materialType) && $getMaterial->materialType == "Video") selected="selected"
                                        @else @if(!empty(old('materialType')) && old('materialType') == "Video") selected="selected" @endif @endif>@lang('adminmaterial.video')</option>
                                <option value="Pdf"
                                        @if(!empty($getMaterial->materialType) && $getMaterial->materialType == "Pdf") selected="selected"
                                        @else @if(!empty(old('materialType')) && old('materialType') == "Pdf") selected="selected" @endif @endif>@lang('adminmaterial.pdf')</option>
                                <option value="Image"
                                        @if(!empty($getMaterial->materialType) && $getMaterial->materialType == "Image") selected="selected"
                                        @else @if(!empty(old('materialType')) && old('materialType') == "Image") selected="selected" @endif @endif>@lang('adminmaterial.image')</option>
                                <option value="Text"
                                        @if(!empty($getMaterial->materialType) && $getMaterial->materialType == "Text") selected="selected"
                                        @else @if(!empty(old('materialType')) && old('materialType') == "Text") selected="selected" @endif @endif>@lang('adminmaterial.txt')</option>
                                <option value="Link"
                                        @if(!empty($getMaterial->materialType) && $getMaterial->materialType == "Link") selected="selected"
                                        @else @if(!empty(old('materialType')) && old('materialType') == "Link") selected="selected" @endif @endif>@lang('adminmaterial.link')</option>
                                <option value="Document"
                                        @if(!empty($getMaterial->materialType) && $getMaterial->materialType == "Document") selected="selected"
                                        @else @if(!empty(old('materialType')) && old('materialType') == "Document") selected="selected" @endif @endif>@lang('adminmaterial.document')</option>
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
                            <div class="">
                                <div class="form-group">
                                    <div class="form-group {{ $errors->has('materialName') ? ' has-error' : '' }}">
                                        <label>@lang('adminmaterial.materialname')<em>*</em></label>
                                        <input type="text" class="form-control" name="materialName"
                                               value="@if(!empty($getMaterial->materialName)){{$getMaterial->materialName}}@else{{ old('materialName') }}@endif"
                                               placeholder="@lang('adminmaterial.materialname')">
                                        @if ($errors->has('materialName'))
                                            <span class="help-block">
                                                        <strong>{{ $errors->first('materialName') }}</strong>
                                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                                        <label>@lang('adminmaterial.description')</label>
                                        <textarea name="description" rows="5" cols="39">@if(!empty($getMaterial->description)){{$getMaterial->description}}@else{{ old('description') }}@endif</textarea>
                                        @if ($errors->has('description'))
                                            <span class="help-block">
                                                        <strong>{{ $errors->first('description') }}</strong>
                                                    </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group {{ $errors->has('default_language') ? ' has-error' : '' }}">
                                    <label>@lang('general.select_language')<em>*</em></label>
                                    <select id="default_language" class="selectpicker" name="default_language">
                                        <option value="">@lang('general.select_language')</option>
                                        @if(config('language.option'))
                                            @foreach(config('language.option') as $key=>$value)
                                                <option value="{{$key}}" @if(old('default_language') == $key) selected @endif @if(!empty($getMaterial->language) && $getMaterial->language == $key) selected @endif >{{$value}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @if ($errors->has('default_language'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('default_language') }}</strong>
                                            </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="categoryId" value="5">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xs-12">
                            <div class="">


                                <div id="upload-contents"
                                     style="display:@if(!empty($getMaterial->materialType) && $getMaterial->materialType == "Link") none @else @if(!empty(old('materialType')) && old('materialType') == "Link") none  @else  block @endif @endif">
                                    <div class="form-group {{ $errors->has('uploadcontent') ? ' has-error' : '' }}">

                                        <label>@lang('adminmaterial.selectmaterial')<em>*</em></label> <br />
                                        <label class="btn btn-vdesk btn-file">
                                            <span id="uploadcontent">@lang('adminmaterial.uploadmaterial')...</span>
                                            <input id="uploadcontent" type="file" class="form-control"
                                                   name="uploadcontent" style="display:none;"
                                                   value="@if(isset($getMaterial->link)) {{ $getMaterial->link }} @endif" onchange="showSelectedFileName(this)">
                                        </label>

                                        @if(!empty($getMaterial->link) && $getMaterial->materialType != "Link")
                                            {{--@if($isValid == false)--}}
                                            <input id="current_uploadcontent" type="hidden"
                                                   name="current_uploadcontent"
                                                   value="@if(isset($getMaterial->link)) {{ $getMaterial->link }} @endif">
                                            {{--@endif--}}
                                        @endif

                                        @if ($errors->has('uploadcontent'))
                                            <span class="help-block">
                                                  <strong>{{ $errors->first('uploadcontent') }}</strong>
                                              </span>
                                        @endif

                                        @if(!empty($getMaterial->materialType) && $getMaterial->materialType != "Link")
                                            {{--@if($isValid == false)--}}
                                            <a href="{{url($getMaterial->link)}}"
                                               target="_blank">@lang('adminmaterial.viewdownload')</a>
                                            {{--@endif--}}
                                        @endif

                                    </div>
                                </div>


                                <div class="form-group col-xs-12" id="upload-externalurl"
                                     style="display:@if(!empty($getMaterial->materialType) && $getMaterial->materialType == "Link") block @else @if(!empty(old('materialType')) && old('materialType') == "Link") block  @else  none @endif @endif">
                                    <div class="form-group {{ $errors->has('link') ? ' has-error' : '' }}">
                                        <label>@lang('adminmaterial.linktitle')<em>*</em></label>
                                        <input type="text" class="form-control" id="thirdPartyLink"
                                               value="@if(!empty($getMaterial->materialType) && $getMaterial->materialType == "Link"){{$getMaterial->link}}@else{{old('link')}}@endif"
                                               name="link" placeholder="@lang('adminmaterial.linktitle')">
                                        @if ($errors->has('link'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('link') }}</strong>
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
                                <button type="submit" name="submit"
                                        class="btn btn-vdesk">@if(isset($getMaterial)) @lang('general.update') @else @lang('general.add') @endif</button> &nbsp;
                                <button type="button" name="btn_back_list" id="btn_back_list" class="btn btn-vdesk-light">@lang('teacher.label_p_backtohome')</button>
                            </div>
                        </div>
                    </div>

                </div>
        </form>

    </div>
</div>