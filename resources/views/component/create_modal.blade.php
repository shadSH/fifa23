<!-- /vertical form modal -->
<div id="modal_form_vertical" class="modal fade" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog @stack('modal_type')">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white border-0">
                <h6 class="modal-title">@stack('modal_header')</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                @yield('form')
            </div>
        </div>
    </div>
</div>
<!-- /vertical form modal -->
