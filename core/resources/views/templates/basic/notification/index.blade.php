@extends($activeTemplate . 'layouts.master')
@section('content')
@php
    $notifications = getContent('notice.element')
@endphp
    <!-- main page content -->
    <div class="main-container container pt-0">
        <!-- notification list -->
        <div class="row">
            <div class="col-12 px-0">
                <div class="list-group list-group-flush bg-none">
                    <div class="list-group-item bg-light py-2 text-mute">{{$pageTitle}}</div>
                    @forelse ($notifications as $item)
                        <a class="list-group-item bg-white">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="avatar avatar-44 coverimg rounded-10">
                                        <img src="https://cdn-icons-png.flaticon.com/512/1592/1592461.png" alt="">
                                    </div>
                                </div>
                                <div class="col align-self-center ps-0">
                                    <p class="mb-1">
                                        {{$item->data_values->title}}
                                    </p>
                                    <p class="size-12 text-muted">
                                        {{-- {{Str::limit($item->data_values->description, 100)}} --}}
                                        {{$item->data_values->description}}
                                    </p>
                                </div>
                            </div>
                        </a>
                    @empty
                        
                    @endforelse
                    
                </div>
            </div>
        </div>
    </div>
    <!-- main page content ends -->
@endsection
