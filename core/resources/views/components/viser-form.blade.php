@props([
    'classProperty' => '',
    'parentClass' => '',
    'checkboxClass' => 'form-check',
])

@foreach ($formData as $data)
    <div class="form-group {{ $parentClass }}">
        {{-- <label class="form-label">{{ __($data->name) }}</label> --}}
        @if ($data->type == 'text')
        <div class="form-group form-floating mb-3">
            <input class="form-control" name="{{ $data->label }}" type="text" value="{{ old($data->label) }}" @if ($data->is_required == 'required') required @endif>
            <label class="form-label">{{ __($data->name) }}</label>
        </div>
        
        @elseif($data->type == 'textarea')
        <div class="form-group form-floating mb-3">
            <textarea class="form-control" name="{{ $data->label }}" @if ($data->is_required == 'required') required @endif>{{ old($data->label) }}</textarea>
            <label class="form-label">{{ __($data->name) }}</label>
        </div>
        @elseif($data->type == 'select')
            {{-- <label class="form-label ms-2">{{ __($data->name) }}</label> --}}
            <select class="form-control form-select py-3 mb-3" name="{{ $data->label }}" @if ($data->is_required == 'required') required @endif>
                <option value="">@lang($data->name)</option>
                @foreach ($data->options as $item)
                    <option value="{{ $item }}" @selected($item == old($data->label))>{{ __($item) }}</option>
                @endforeach
            </select>
        @elseif($data->type == 'checkbox')
            @foreach ($data->options as $option)
                <div class="{{ $checkboxClass }}">
                    <input class="form-check-input" id="{{ $data->label }}_{{ titleToKey($option) }}" name="{{ $data->label }}[]" type="checkbox" value="{{ $option }}">
                    <label class="form-check-label" for="{{ $data->label }}_{{ titleToKey($option) }}">{{ $option }}</label>
                </div>
            @endforeach
        @elseif($data->type == 'radio')
            @foreach ($data->options as $option)
                <div class="form-check">
                    <input class="form-check-input" id="{{ $data->label }}_{{ titleToKey($option) }}" name="{{ $data->label }}" type="radio" value="{{ $option }}" @checked($option == old($data->label))>
                    <label class="form-check-label" for="{{ $data->label }}_{{ titleToKey($option) }}">{{ $option }}</label>
                </div>
            @endforeach
        @elseif($data->type == 'file')
        <div class="form-group form-floating mb-3">
            <input class="form-control" name="{{ $data->label }}" type="file" @if ($data->is_required == 'required') required @endif accept="@foreach (explode(',', $data->extensions) as $ext) .{{ $ext }}, @endforeach">
            <pre class="text--base mt-1 {{ $classProperty }}">@lang('Supported mimes'): {{ $data->extensions }}</pre>
        </div>
        @endif
    </div>
@endforeach
