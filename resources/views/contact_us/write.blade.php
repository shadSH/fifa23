<!-- Vertical form modal -->
<div id="modal_form_vertical" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="card-body">
                <form  method="post" action="{{ route('contact_us.send_mail') }}" class="form-validate-jquery main_form" id="main_form">
                    {{ csrf_field() }}

                    <div class="content">

                        <!-- Single mail -->
                        <div class="card">

                            <!-- Action toolbar -->
                            <div class="navbar navbar-light navbar-expand-lg border-bottom-0 py-lg-2 rounded-top">
                                <div class="text-center d-lg-none w-100">
                                    <button type="button"  class="navbar-toggler w-100 h-100" data-toggle="collapse" data-target="#inbox-toolbar-toggle-write">
                                        <i class="icon-circle-down2"></i>
                                    </button>
                                </div>

                                <div class="navbar-collapse text-center text-lg-left flex-wrap collapse" id="inbox-toolbar-toggle-write">

                                    <div class="mt-3 mt-lg-0 mr-lg-3">
                                        <button type="submit" class="btn btn-primary"><i class="icon-paperplane mr-2"></i> Send mail</button>
                                    </div>

                                </div>
                            </div>
                            <!-- /action toolbar -->


                            <!-- Mail details -->
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td class="align-top py-0" style="width: 1%">
                                            <div class="py-2 mr-sm-3">To:</div>
                                        </td>
                                        <td class="align-top py-0">
                                            <div class="d-sm-flex flex-sm-wrap">
                                                <input type="text" name="to" class="form-control h-auto flex-fill w-auto py-2 px-0 border-0 rounded-0" placeholder="Add recipients">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="align-top py-0">
                                            <div class="py-2 mr-sm-3">Subject:</div>
                                        </td>
                                        <td class="align-top py-0">
                                            <input type="text" name="subject" class="form-control h-auto py-2 px-0 border-0 rounded-0" placeholder="Add subject">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /mail details -->


                            <!-- Mail container -->
                            <div class="card-body p-0">
                                <div class="overflow-auto mw-100">
                                   <textarea name="message" id="editor-full" rows="4" cols="4">

                                   </textarea>
                                </div>
                            </div>
                            <!-- /mail container -->


                        </div>
                        <!-- /single mail -->

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /vertical form modal -->
