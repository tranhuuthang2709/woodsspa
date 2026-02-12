@extends('index')

@section('content')
<header>
    @include('layouts.header')
</header>

<section class="position-relative m-0 p-0 hero-section">
  <img src="{{ asset('assets/img/phong22.png') }}" alt="Banner" class="w-100 hero-img">

  <div class="position-absolute text-white ps-5 hero-content">
      <h1 class="fw-bold text-uppercase mb-3">{{__('messages.menudichvu')}}</h1>
      <p>{{__('messages.motatimkiem')}}</p>

      <div class="bg-white rounded-pill shadow d-inline-flex align-items-center px-3 py-2 search-bar">
          <i class="bi bi-search me-2 text-muted"></i>
          <input type="text" id="searchService" class="form-control border-0 shadow-none" placeholder="{{__('messages.timkiem')}}...">
      </div>
  </div>
</section>

<style>
.hero-img {
    height: 90vh;
    object-fit: cover;
    display: block;
}
.hero-content {
    top: 80%;
    left: 0;
    transform: translateY(-50%);
}

@media (max-width: 768px) {
    .hero-img {
        height: 50vh; 
    }
    .hero-content {
        top: 75%;
        padding-left: 1rem; 
    }
}
</style>

<div class="container my-5">
  <!-- Tabs danh mục -->
  <ul class="nav nav-tabs border-0 mb-4 d-flex flex-nowrap overflow-auto">
    <li class="nav-item">
      <a class="nav-link active text-uppercase" data-bs-toggle="tab" href="#all">{{ __('messages.tatcadichvu') }}</a>
    </li>
    @foreach($categories as $category)
      <li class="nav-item">
        <a class="nav-link text-uppercase" data-bs-toggle="tab" href="#cat-{{ $category->id }}">{{ $category->translated_name }}</a>
      </li>
    @endforeach
  </ul>

  <div class="tab-content">
    <!-- Tab All -->
    <div class="tab-pane fade show active" id="all">
      <div class="row g-4">
        @foreach($services as $service)
          <div class="col-md-4 service-item" data-name="{{ strtolower($service->translated_name) }}">
            <div class="card h-100 shadow-sm">
              <img src="{{ asset('storage/' . $service->image) }}" class="card-img-top" alt="{{ $service->translated_name }}">
              <div class="card-body">
                <h6 class="card-title main-color">{{ $service->translated_name }}</h6>
                <p class="card-text d-flex align-items-center">
                  <span class="main-color">{{ $service->duration }}' /</span>
                  @if ($service->sale_price)
                    <del class="text-muted ms-1">
                      {{ app()->getLocale() == 'vi' ? number_format($service->price, 0, ',', '.') : '$'.number_format($service->price, 0, '.', ',') }}
                    </del>
                    <span class="fw-bold main-color ms-1">
                      {{ app()->getLocale() == 'vi' ? number_format($service->sale_price, 0, ',', '.') . ' VND' : '$'.number_format($service->sale_price, 0, '.', ',') }}
                    </span>
                  @else
                    <span class="fw-bold main-color ms-1">
                      {{ app()->getLocale() == 'vi' ? number_format($service->price, 0, ',', '.') . ' VND' : '$'.number_format($service->price, 0, '.', ',') }}
                    </span>
                  @endif
                </p>
                <div class="d-flex justify-content-end">
                  <a href="{{ route('service.detail', ['serviceId' => $service->id]) }}" class="btn btn-primary rounded-circle shadow-sm">
                    <i class="bi bi-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <!-- Tabs theo category -->
    @foreach($categories as $category)
      <div class="tab-pane fade" id="cat-{{ $category->id }}">
        <div class="row g-4">
          @foreach($services->where('category_id', $category->id) as $service)
            <div class="col-md-4 service-item" data-name="{{ strtolower($service->translated_name) }}">
              <div class="card h-100 shadow-sm">
                <img src="{{ asset('storage/' . $service->image) }}" class="card-img-top" alt="{{ $service->translated_name }}">
                <div class="card-body">
                  <h6 class="card-title main-color">{{ $service->translated_name }}</h6>
                  <p class="card-text d-flex align-items-center">
                    <span class="main-color">{{ $service->duration }}' /</span>
                    @if ($service->sale_price)
                      <del class="text-muted ms-1">
                        {{ app()->getLocale() == 'vi' ? number_format($service->price, 0, ',', '.') : '$'.number_format($service->price, 0, '.', ',') }}
                      </del>
                      <span class="fw-bold main-color ms-1">
                        {{ app()->getLocale() == 'vi' ? number_format($service->sale_price, 0, ',', '.') . ' VND' : '$'.number_format($service->sale_price, 0, '.', ',') }}
                      </span>
                    @else
                      <span class="fw-bold main-color ms-1">
                        {{ app()->getLocale() == 'vi' ? number_format($service->price, 0, ',', '.') . ' VND' : '$'.number_format($service->price, 0, '.', ',') }}
                      </span>
                    @endif
                  </p>
                  <div class="d-flex justify-content-end">
                    <a href="{{ route('service.detail', ['serviceId' => $service->id]) }}" class="btn btn-primary rounded-circle shadow-sm">
                      <i class="bi bi-arrow-right"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endforeach
  </div>
</div>

<!-- Scripts -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.getElementById('searchService');
  const services = document.querySelectorAll('.service-item');

  // Search service
  searchInput.addEventListener('input', function() {
    const keyword = this.value.toLowerCase().trim();
    services.forEach(s => {
      const name = s.dataset.name;
      s.style.display = name.includes(keyword) ? '' : 'none';
    });
  });

  // Active tab dựa vào query string ?category=
  const urlParams = new URLSearchParams(window.location.search);
  const categoryId = urlParams.get('category');

  if(categoryId) {
    // Hủy active tab hiện tại
    document.querySelectorAll('.nav-link').forEach(tab => tab.classList.remove('active'));
    document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('show','active'));

    // Active tab và pane tương ứng
    const tabLink = document.querySelector(`.nav-link[href="#cat-${categoryId}"]`);
    const tabPane = document.querySelector(`#cat-${categoryId}`);
    if(tabLink && tabPane){
      tabLink.classList.add('active');
      tabPane.classList.add('show','active');
    }

    // Scroll xuống section tab
    const tabSection = document.querySelector('.nav-tabs');
    if(tabSection) tabSection.scrollIntoView({behavior:'smooth'});
  }
});
</script>

<style>
.search-bar {
  min-width: 200px;
}

@media (min-width: 992px) {
  .search-bar {
    min-width: 450px;
    padding: 0.75rem 1.5rem !important;
  }

  .search-bar input {
    font-size: 1.1rem;
  }
}
</style>
@endsection
