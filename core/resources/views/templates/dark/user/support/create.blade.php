@extends($activeTemplate . 'layouts.master')
@section('content')
    <h5>{{ __($pageTitle) }}</h5>
    <div class="contact-form">
        <form action="{{ route('ticket.store') }}" method="post" enctype="multipart/form-data" onsubmit="return submitUserForm();">
            @csrf
            <input name="email" type="hidden" value="{{ auth()->user()->email }}">
            <input name="name" type="hidden" value="{{ auth()->user()->fullname }}">
            <div class="row gy-4">
                <div class="col-sm-6">
                    <label class="form-label">@lang('Subject')</label>
                    <input class="form--control" name="subject" type="text" value="{{ old('subject') }}" required>
                </div>
                <div class="col-sm-6">
                    <label class="form-label">@lang('Priority')</label>
                    <select class="custom--select form--control" name="priority" required>
                        <option value="3" @selected(old('priority' == 3))>@lang('High')</option>
                        <option value="2" @selected(old('priority' == 2))>@lang('Medium')</option>
                        <option value="1" @selected(old('priority' == 1))>@lang('Low')</option>
                    </select>
                </div>
                <div class="col-12 form-group">
                    <label class="form-label">@lang('Message')</label>
                    <textarea class="form--control" id="inputMessage" name="message" rows="6" required>{{ old('message') }}</textarea>
                </div>
                <div class="col-12 text-end">
                    <button class="btn btn--base btn-sm addFile" type="button">
                        <i class="fa fa-plus"></i> @lang('Add New')
                    </button>
                </div>
                <div class="form-group">
                    <div class="file-upload">
                        <label class="form-label">@lang('Attachments') <small class="text-danger">@lang('Max 5 files can be uploaded'). @lang('Maximum upload size is') {{ ini_get('upload_max_filesize') }}</small> </label>
                        <input class="form-control form--control mb-2" id="inputAttachments" name="attachments[]" type="file" accept=".png, .jpg, .jpeg,.pdf,.doc,.docx" />
                        <div id="fileUploadsContainer"></div>
                        <p class="ticket-attachments-message text-muted">
                            @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'), .@lang('pdf'), .@lang('doc'), .@lang('docx')
                        </p>
                    </div>

                </div>

                <div class="form-group">
                    <button class="btn btn--base w-100" id="recaptcha" type="submit">@lang('Submit')</button>
                </div>
            </div>

        </form>
    </div>
@endsection

@push('style')
    <style>
        .input-group-text:focus {
            box-shadow: none !important;
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
                    <div class="input-group my-4">
                        <input type="file" name="attachments[]" class="form-control form--control" required accept=".png, .jpg, .jpeg,.pdf,.doc,.docx"/>
                        <button class="input-group-text btn--danger remove-btn"><i class="las la-times"></i></button>
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
