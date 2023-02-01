@auth
    <!-- welcome user -->
    <div class="row mb-4">
        <div class="col-auto">
            <div class="avatar avatar-50 shadow rounded-10">
                @if (auth()->user()->image != null)
                    <img src="{{ asset($customImgPath . 'user/profile/' . auth()->user()->image) }}" alt="">
                @else
                    <img src="https://i1.sndcdn.com/artworks-000331665039-ur0qza-t500x500.jpg" alt="">
                @endif
            </div>
        </div>
        <div class="col align-self-center ps-0">
            <h4 class="text-color-theme"><span class="fw-normal">Hi</span>,
                {{ auth()->user()->firstname . ' ' . auth()->user()->lastname }}</h4>
            <p class="text-muted">{{ dayTimeName() }}</p>
        </div>
    </div>
@endauth
@guest
    <!-- welcome user -->
    <div class="row mb-4">
        <div class="col-auto">
            <div class="avatar avatar-50 shadow rounded-10">
                <img src="https://i1.sndcdn.com/artworks-000331665039-ur0qza-t500x500.jpg" alt="">
            </div>
        </div>
        <div class="col align-self-center ps-0">
            <h4 class="text-color-theme"><span class="fw-normal">Hi</span>, Guest</h4>
            <p class="text-muted">{{ dayTimeName() }}</p>
        </div>
    </div>
@endguest
