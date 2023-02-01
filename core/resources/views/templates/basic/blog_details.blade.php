@extends($activeTemplate . 'layouts.frontend')
@section('content')
<!-- main page content -->
<div class="main-container container">

    <!-- Blog/News Details banner -->
    <div class="row">
        <div class="col-12 px-0">
            <div class="card mb-4 overflow-hidden shadow-sm theme-bg text-white rounded-0">
                <div class="overlay"></div>
                <div class="coverimg h-100 w-100 position-absolute opacity-5">
                    <img src="{{ getImage('assets/images/frontend/blog/' . @$blog->data_values->blog_image, '708x472') }}" alt="">
                </div>
                <div class="card-body">
                    <div class="row mb-5">
                        <div class="col">
                            <span class="tag">Trending</span>
                        </div>
                        <div class="col-auto pe-1">
                            <div class="dropdown">
                                <button class="btn btn-danger text-white btn-44 rounded-circle shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-share"></i>
                                </button>
                                <ul style="min-width: 0;" class="dropdown-menu">
                                    <li class="dropdown-item px-1">
                                        <a class="btn btn-primary btn-sm bg-blue" href="http://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}">
                                            <i class="bi bi-facebook"></i>
                                        </a>
                                    </li>
                                    <li class="dropdown-item px-1">
                                        <a class="btn btn-info btn-sm bg-cyan text-white" href="https://twitter.com/intent/tweet?text=my share text&amp;url={{ urlencode(url()->current()) }}">
                                            <i class="bi bi-twitter"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-auto ps-1">
                            <button class="btn btn-success text-white btn-44 rounded-circle shadow-sm">
                                <i class="bi bi-bookmark"></i>
                            </button>
                        </div>
                    </div>
                    <br>
                    <a href="blog-details.html" class="h4 text-normal d-block text-white mb-2">{{ $blog->data_values->title }}</a>
                    <p class="text-muted">Published on: {{ showDateTime($blog->created_at, 'd/m/Y') }}</p>
                    <div class="small d-flex">
                        <figure class="avatar avatar-36 rounded">
                            <img src="https://www.shareicon.net/data/2016/04/14/492851_admin_256x256.png" alt="">
                        </figure>
                        <p class="mx-2">Admin<br><span class="text-muted">Author</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Blogs/News Content  -->
    <div class="row">
        <div class="col-12 col-md-10 col-lg-8 mx-auto">
            @php echo $blog->data_values->description @endphp
        </div>
    </div>

    <div class="clearfix"></div>
</div>
<!-- main page content ends -->








    <!-- blog-section start -->
    {{-- <section class="blog-section ptb-120">
        <div class="container">
            <div class="row justify-content-center ml-b-30">
                <div class="col-lg-8 mrb-30">
                    <div class="blog-item">
                        <div class="blog-thumb">
                            <img src="{{ getImage('assets/images/frontend/blog/' . @$blog->data_values->blog_image, '708x472') }}" alt="Blog">
                            <span class="overlay-date">{{ showDateTime($blog->created_at, 'd, M') }}</span>
                        </div>
                        <div class="blog-content">
                            <h3 class="title">{{ $blog->data_values->title }}</h3>
                            @php echo $blog->data_values->description @endphp
                            <div class="follow-us d-flex align-items-center flex-wrap gap-2">
                                <h4 class="follow-title me-2 mb-0"> @lang('Share On') - </h4>
                                <ul class="social-list">
                                    <li class="social-list__item">
                                        <a class="social-list__link" href="http://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"><i class="lab la-facebook-f"></i></a>
                                    </li>

                                    <li class="social-list__item">
                                        <a class="social-list__link" href="https://twitter.com/intent/tweet?text=my share text&amp;url={{ urlencode(url()->current()) }}"><i class="lab la-twitter"></i></a>
                                    </li>

                                    <li class="social-list__item">
                                        <a class="social-list__link" href="http://www.linkedin.com/shareArticle?mini=true&amp;url={{ urlencode(url()->current()) }}"><i class="lab la-linkedin-in"></i></a>
                                    </li>

                                    <li class="social-list__item">
                                        <a class="social-list__link" href="https://www.instagram.com/?url={{ urlencode(url()->current()) }}"><i class="lab la-instagram"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="fb-comments mt-4" data-href="{{ url()->current() }}" data-width="" data-numposts="5"></div>

                </div>
                <div class="col-lg-4 mrb-30">
                    <div class="sidebar">
                        <div class="widget-box">
                            <h5 class="widget-title">@lang('Latest Blogs')</h5>
                            <div class="popular-widget-box">
                                @foreach ($latestBlogs as $latestBlog)
                                    <div class="single-popular-item d-flex align-items-center flex-wrap">
                                        <div class="popular-item-thumb">
                                            <img src="{{ getImage('assets/images/frontend/blog/thumb_' . @$latestBlog->data_values->blog_image, '318x212') }}" alt="@lang('blog')">
                                        </div>
                                        <div class="popular-item-content">
                                            <h5 class="title"><a href="{{ route('blog.details', [slug($latestBlog->data_values->title), $latestBlog->id]) }}">{{ __($latestBlog->data_values->title) }}</a></h5>
                                            <span class="blog-date">{{ showDateTime(@$latestBlog->created_at, $format = 'd F, Y') }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <!-- blog-section end -->
@endsection
