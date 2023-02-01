@extends($activeTemplate . 'layouts.frontend')

@section('content')

<!-- main page content -->
<div class="main-container container">
    <!-- Blogs news pages -->
    <div class="row mb-3">
        <div class="col">
            <h5 class="mb-1">Today </h5>
            <p class="text-muted small">{{date('d/m/Y')}}</p>
        </div>
    </div>

    <!-- Nifty and Infy -->
    {{-- <div class="row bg-theme-light mb-4">
        <div class="col py-3">
            <div class="row no-gutters">
                <div class="col">
                    <p class="mb-0">
                        <span class="text-uppercase">NIFTY</span> <i class="text-success bi bi-arrow-up"></i>
                        <br>
                        <small><span class="text-success">(+0.84)</span> <span
                                class="text-muted">12000</span></small>
                    </p>
                </div>
                <div class="col-auto ps-0 align-self-center">
                    <div class="sparklinechart"></div>
                </div>
            </div>
        </div>
        <div class="col py-3">
            <div class="row no-gutters">
                <div class="col">
                    <p class="mb-0">
                        <span class="text-uppercase">INFYS</span> <i class="text-danger bi-arrow-down"></i>
                        <br>
                        <small><span class="text-danger">(-0.84)</span> <span
                                class="text-muted">12000</span></small>
                    </p>
                </div>
                <div class="col-auto ps-0 align-self-center">
                    <div class="sparklinechart2"></div>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- categories -->
    <div class="row mb-2">
        <div class="col-12 px-0">
            <div class="swiper-container tagsswiper">
                <div class="swiper-wrapper">
                    {{-- <div class="swiper-slide">
                        <div class="tag active">Latest</div>
                    </div>                             --}}
                    <div class="swiper-slide">
                        <div class="tag active">Trending</div>
                    </div>                            
                    {{-- <div class="swiper-slide">
                        <div class="tag ">Movies</div>
                    </div>                            
                    <div class="swiper-slide">
                        <div class="tag ">Sport</div>
                    </div>                            
                    <div class="swiper-slide">
                        <div class="tag ">Business</div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <!-- categories -->
    <div class="row">
        @foreach ($blogs as $blog)
            <div class="col-12 col-md-6">
                <div class="card mb-4 overflow-hidden shadow-sm bg-primary text-white">
                    <div class="overlay"></div>
                    <div class="coverimg h-100 w-100 position-absolute opacity-5">
                        <img src="{{ getImage('assets/images/frontend/blog/thumb_' . @$blog->data_values->blog_image, '318x212') }}" alt="">
                    </div>
                    <div class="card-body">
                        <div class="row mb-5">
                            <div class="col align-self-center">
                                <span class="tag">Trending</span>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-danger text-white btn-44 rounded-circle shadow-sm">
                                    <i class="bi bi-share"></i>
                                </button>
                                <button class="btn btn-success text-white btn-44 rounded-circle shadow-sm">
                                    <i class="bi bi-bookmark"></i>
                                </button>
                            </div>
                        </div>
                        <br>
                        <a href="{{ route('blog.details', [slug($blog->data_values->title), $blog->id]) }}" class="h4 text-normal d-block text-white mb-2">
                            {{ $blog->data_values->title }}
                        </a>
                        <p class="text-muted">
                            @php echo strLimit(strip_tags($blog->data_values->description), 80) @endphp
                            <b><a class="text-warning" href="{{ route('blog.details', [slug($blog->data_values->title), $blog->id]) }}">Read more</a></b>
                        </p>
                        <div class="small">
                            <figure class="avatar avatar-20 rounded mx-1">
                                <img src="https://www.shareicon.net/data/2016/04/14/492851_admin_256x256.png" alt="">
                            </figure>
                            Admin
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{ paginateLinks($blogs) }}
</div>
<!-- main page content ends -->




    <!-- blog-section start -->
    {{-- <section class="blog-section ptb-120">
        <div class="container">
            <div class="row justify-content-center ml-b-30">
                @foreach ($blogs as $blog)
                    <div class="col-lg-4 col-md-6 col-sm-12 mrb-30">
                        <div class="blog-item">
                            <div class="blog-thumb">
                                <img src="{{ getImage('assets/images/frontend/blog/thumb_' . @$blog->data_values->blog_image, '318x212') }}" alt="@lang('Blog')">
                                <span class="overlay-date">{{ strtoupper(showDateTime($blog->created_at, 'd, M')) }}</span>
                            </div>
                            <div class="blog-content">
                                <h3 class="title"><a href="{{ route('blog.details', [slug($blog->data_values->title), $blog->id]) }}">{{ $blog->data_values->title }}</a></h3>
                                <p> @php echo strLimit(strip_tags($blog->data_values->description), 80) @endphp</p>
                                <div class="blog-btn">
                                    <a class="custom-btn" href="{{ route('blog.details', [slug($blog->data_values->title), $blog->id]) }}">@lang('Read More') <i class="fas fa-angle-double-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{ paginateLinks($blogs) }}
        </div>
    </section> --}}
    <!-- blog-section end -->

    @if ($sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include($activeTemplate . 'sections.' . $sec)
        @endforeach
    @endif

@endsection
