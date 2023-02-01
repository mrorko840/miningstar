@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="main-container container pt-0">
        <div class="row justify-content-center mt-4">
            <div class="col-md-12">
                <div class="card custom--card">
    
                    <div class="card-body">
                        <form action="{{ route('ticket.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
    
                            <input name="email" type="hidden" value="{{ auth()->user()->email }}">
                            <input name="name" type="hidden" value="{{ auth()->user()->fullname }}">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">@lang('Subject')</label>
                                    <input class="form-control rounded-pill" name="subject" type="text" value="{{ old('subject') }}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">@lang('Priority')</label>
                                    <select class="form-select rounded-pill" name="priority" required>
                                        <option value="3" @selected(old('priority' == 3))>@lang('High')</option>
                                        <option value="2" @selected(old('priority' == 2))>@lang('Medium')</option>
                                        <option value="1" @selected(old('priority' == 1))>@lang('Low')</option>
                                    </select>
                                </div>
                                <div class="col-12 form-group">
                                    <label class="form-label">@lang('Message')</label>
                                    <textarea class="form-control" id="inputMessage" name="message" rows="6" required>{{ old('message') }}</textarea>
                                </div>
                            </div>
    
                            <div class="form-group mt-2">
                                <div class="d-flex justify-content-between align-items-center flex-wrap">
                                    <label class="form-label align-self-end mb-0">@lang('Attachments')</label>
                                    <button class="btn btn-info btn-sm rounded-pill addFile mb-0" type="button">
                                        <i class="bi bi-plus-circle"></i> @lang('Add New')
                                    </button>
                                </div>
                                <div class="file-upload">
                                    <small class="text-danger small">@lang('Maximum upload size is') {{ ini_get('upload_max_filesize') }}</small>
                                    <input class="form-control mb-2" id="inputAttachments" name="attachments[]" type="file" accept=".png, .jpg, .jpeg,.pdf,.doc,.docx" />
                                    <div id="fileUploadsContainer"></div>
                                    <p class="ticket-attachments-message text-muted">
                                        @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')
                                    </p>
                                </div>
    
                            </div>
    
                            <div class="form-group">
                                <button class="btn btn-warning btn-sm rounded-pill w-100" type="submit"><i class="fa fa-paper-plane"></i>&nbsp;@lang('Submit')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .input-group-text:focus {
            box-shadow: none !important;
        }

        .card-body .addFile {
            margin-bottom: -50px;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            var fileAdded = 0;
            $('.addFile').on('click', function() {
                if (fileAdded >= 4) {
                    notify('error', 'You\'ve added maximum number of file');
                    return false;
                }
                fileAdded++;
                $("#fileUploadsContainer").append(`
                    <div class="input-group my-3">
                        <input type="file" name="attachments[]" class="form-control" required  accept=".png, .jpg, .jpeg,.pdf,.doc,.docx"/>
                        <button type="button" class="input-group-text btn-danger remove-btn"><i class="bi bi-x-lg"></i></button>
                    </div>
                `)
            });
            $(document).on('click', '.remove-btn', function() {
                fileAdded--;
                $(this).closest('.input-group').remove();
            });
        })(jQuery);
    </script>
@endpush
