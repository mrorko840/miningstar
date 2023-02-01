@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card custom--card">
                <div class="card-header">
                    <h5 class="card-title">@lang('KYC Form')</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.kyc.submit') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row gy-4">
                            <x-viser-form identifier="act" identifierValue="kyc" classProperty="mb-0" parentClass="form-check-wrapper" />

                            <div class="form-group">
                                <button class="btn btn--base w-100" type="submit">@lang('Submit')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
