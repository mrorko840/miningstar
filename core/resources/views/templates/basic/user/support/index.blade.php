@extends($activeTemplate . 'layouts.master')
@section('content')
<div class="container">
    <!-- Support Tickets -->
    <div class="row mb-3">
        <div class="col">
            <h6 class="title">Support Tickets<br><small class="fw-normal text-muted">Today, {{date('d M Y')}}</small>
            </h6>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12 px-0">
            <ul class="list-group list-group-flush bg-none">
                @forelse ($supports as $support)
                    <li class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <div class="avatar avatar-50 shadow rounded-10 ">
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSS392fEI_-KdITvgFHAzNQT0rPkdqqDEKY1Q&usqp=CAU" alt="">
                                </div>
                            </div>
                            <div class="col-7 align-self-center ps-0">
                                <p class="text-color-theme mb-0">
                                    {{ __($support->subject) }} [Ticket #{{ $support->ticket }}]
                                </p>
                                <p class="text-muted size-12 mb-0">
                                    @php echo $support->priorityBadge; @endphp
                                </p>
                                <small>{{ diffForHumans($support->last_reply) }}</small>
                            </div>
                            <div class="col align-self-center text-end">
                                <a class="btn btn-warning btn-sm mb-1 py-0" href="{{ route('ticket.view', $support->ticket) }}">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                <p class="text-muted size-12">
                                    @php echo $support->statusBadge @endphp
                                </p>
                            </div>
                        </div>
                    </li>
                @empty

                @endforelse
            </ul>
            {{ paginateLinks($supports) }}
        </div>
    </div>
</div>






    {{-- <div class="order-section pd-b-80">
        <div class="row justify-content-center ml-b-30">
            <div class="col-lg-12 mrb-30">
                <div class="order-table-area">
                    <table class="table--responsive--lg table">
                        <thead>
                            <tr>
                                <th>@lang('Subject')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Priority')</th>
                                <th>@lang('Last Reply')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($supports as $support)
                                <tr>
                                    <td> <a class="fw-bold" href="{{ route('ticket.view', $support->ticket) }}"> <small>[@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }}</small>
                                        </a></td>
                                    <td>
                                        @php echo $support->statusBadge; @endphp
                                    </td>
                                    <td>
                                        @php echo $support->priorityBadge; @endphp
                                    </td>
                                    <td><small>{{ diffForHumans($support->last_reply) }}</small></td>

                                    <td>
                                        <a class="btn btn-icon btn-sm" href="{{ route('ticket.view', $support->ticket) }}">
                                            <i class="las la-desktop"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ paginateLinks($supports) }}
                </div>
            </div>
        </div>
    </div> --}}
@endsection
