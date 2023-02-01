
<!-- Blogs -->
<div class="row mb-3">
    <div class="col">
        <h6 class="title">News and Upcomming</h6>
    </div>
    {{-- <div class="col-auto align-self-center">
        <a href="blog.html" class="small">Read more</a>
    </div> --}}
</div>
<div class="row">
    @foreach ($news as $item)
        <div class="col-12 col-md-6 col-lg-4">
            <a class="card mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="avatar avatar-60 shadow-sm rounded-10 coverimg">
                                <img src="{{ asset($customImgPath . 'frontend/news/'. $item->data_values->image) }}" alt="">
                            </div>
                        </div>
                        <div class="col align-self-center ps-0">
                            <p class="text-color-theme mb-1">{{$item->data_values->title}}</p>
                            <p class="text-muted size-12">{{$item->data_values->description}}</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>
