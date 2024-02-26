<!-- Vertical form modal -->
<div id="modal_form_vertical" class="modal fade" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white border-0">
                <h6 class="modal-title">@lang('translate.add_client')</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('clients.store') }}" class="form-validate-jquery main_form"
                      id="main_form">
                    {{ csrf_field() }}
                    <ul class="nav nav-tabs nav-tabs-highlight nav-justified mb-4">
                        <li class="nav-item"><a href="#lang_en" class="nav-link active" data-toggle="tab">
                                @lang('translate.en')
                            </a>
                        </li>
                        <li class="nav-item"><a href="#lang_ku" class="nav-link"
                                                data-toggle="tab">@lang('translate.ku')</a></li>
                        <li class="nav-item"><a href="#lang_ar" class="nav-link"
                                                data-toggle="tab">@lang('translate.ar')</a></li>
                        <li class="nav-item"><a href="#lang_tr" class="nav-link"
                                                data-toggle="tab">@lang('translate.tr')</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="lang_en">
                            <div class="form-group mb-3">
                                <label class="mb-2">@lang('translate.name_english')</label>
                                <input type="text" class="form-control" name="name" required
                                       placeholder="@lang('translate.name_english')">
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
                                    <input type="hidden" name="image" required class="selected-files">
                                </div>
                                <div class="file-preview box sm"></div>
                            </div>
                        </div>
                        <div class="tab-pane fade mb-3" id="lang_ku">
                            <div class="form-group">
                                <label class="mb-2">@lang('translate.name_kurdish')</label>
                                <input type="text" class="form-control" name="name_ku" placeholder="@lang('translate.name_kurdish')">
                            </div>
                        </div>
                        <div class="tab-pane fade mb-3" id="lang_ar">
                            <div class="form-group">
                                <label class="mb-2">@lang('translate.name_arabic')</label>
                                <input type="text" class="form-control" name="name_ar" placeholder="@lang('translate.name_arabic')">
                            </div>
                        </div>
                        <div class="tab-pane fade mb-3" id="lang_tr">
                            <div class="form-group">
                                <label class="mb-2">@lang('translate.name_turkish')</label>
                                <input type="text" class="form-control" name="name_tr" placeholder="@lang('translate.name_turkish')">
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
<!-- /vertical form modal -->
