<!-- Vertical Edit form modal -->
<script src="{{asset("global_assets/js/plugins/forms/selects/select2.min.js")}}"></script>
<div id="modal_form_vertical_edit" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white border-0">
                <h5 class="modal-title text-white">@lang('translate.edit_client')</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="" class="form-validate-jquery main_form_edit" id="main_form_edit">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <ul class="nav nav-tabs nav-tabs-highlight nav-justified mb-4">
                        <li class="nav-item"><a href="#lang_en_edit" class="nav-link active"
                                                data-toggle="tab">@lang('translate.en')</a>
                        </li>
                        <li class="nav-item"><a href="#lang_ku_edit" class="nav-link"
                                                data-toggle="tab">@lang('translate.ku')</a></li>
                        <li class="nav-item"><a href="#lang_ar_edit" class="nav-link"
                                                data-toggle="tab">@lang('translate.ar')</a></li>
                        <li class="nav-item"><a href="#lang_tr_edit" class="nav-link"
                                                data-toggle="tab">@lang('translate.tr')</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="lang_en_edit">
                            <div class="form-group mb-3">
                                <label class="mb-2">@lang('translate.name_english')</label>
                                <input type="text" class="form-control" name="name" required
                                       placeholder="@lang('translate.name_english')" value="{{$client_update->name}}">
                            </div>
                            <div class="form-group mb-3">
                                <label class="mb-2">@lang('translate.Image')</label>
                                <div class="input-group" data-toggle="aizuploader" data-type="image"
                                     data-multiple="false">
                                    <div class="input-group-prepend">
                                        <div
                                            class="input-group-text bg-soft-secondary font-weight-medium">@lang('translate.browse')</div>
                                    </div>
                                    <div class="form-control file-amount">@lang('translate.choose_file')</div>
                                    <input type="hidden" name="image" value="{{ $client_update->image }}" required
                                           class="selected-files">
                                </div>
                                <div class="file-preview box sm"></div>
                            </div>
                        </div>
                        <div class="tab-pane fade mb-3" id="lang_ku_edit">
                            <div class="form-group">
                                <label class="mb-2">@lang('translate.name_kurdish')</label>
                                <input type="text" class="form-control" name="name_ku" placeholder="@lang('translate.name_kurdish')"
                                       value="{{$client_update->getTranslation('name','ckb')}}">
                            </div>
                        </div>
                        <div class="tab-pane fade mb-3" id="lang_ar_edit">
                            <div class="form-group">
                                <label class="mb-2">@lang('translate.name_arabic')</label>
                                <input type="text" class="form-control" name="name_ar" placeholder="@lang('translate.name_arabic')"
                                       value="{{$client_update->getTranslation('name','ar')}}">
                            </div>
                        </div>
                        <div class="tab-pane fade mb-3" id="lang_tr_edit">
                            <div class="form-group">
                                <label class="mb-2">@lang('translate.name_turkish')</label>
                                <input type="text" class="form-control" name="name_tr" placeholder="@lang('translate.name_turkish')"
                                       value="{{$client_update->getTranslation('name','tr')}}">
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-dark submit_form">@lang('translate.submit')<i
                                class="icon-paperplane ms-2 send_icon"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /vertical Edit form modal -->
