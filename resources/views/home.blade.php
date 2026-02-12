@extends('index')
@section('content')
<header>
  @include('layouts.header')
</header>
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000">
  <div class="carousel-inner">
    @foreach($banners as $key => $banner)
    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
      <img src="{{ asset('storage/' . $banner->image) }}" class="d-block w-100" alt="Banner {{ $key + 1 }}">
    </div>
    @endforeach
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

<!-- Giới thiệu -->
<section id="about" class="intro">
  <div class="container">
    <div class="row align-items-center mb-3">
      <div class="col-lg-6">
        <img src="{{ asset('assets') }}/img/phong11.png" width="100%" alt="">
      </div>
      <div class="col-lg-6 ps-lg-5 mt-4 mt-lg-0">
        <h2 class="main-color">{{ __('messages.vechungtoi') }}</h2>
        <p>{{__('messages.motatrangchu')}}</p>
        <div class="text-end">
          <a href="#" class="btn btn-primary mt-3">{{__('messages.xemthem')}}</a>
      </div>
      </div>
    </div>

    <!-- Wrapper có khả năng cuộn ngang -->
    <div class="row g-4 scroll-x" style="overflow-x: auto; display: flex; flex-wrap: nowrap;">
      <div class="col-md-4 col-6" style="flex-shrink: 0; ">
        <div class="card service-card">
          <img src="{{ asset('assets') }}/img/phong22.png" class="card-img-top" alt="">
          <div class="card-body text-center">
            <h5>{{__('messages.gioithieu1')}}</h5>
            <p>{{__('messages.motagioithieu1')}}</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-6" style="flex-shrink: 0; ">
        <div class="card service-card">
          <img src="{{ asset('assets') }}/img/phong11.png" class="card-img-top" alt="">
          <div class="card-body text-center">
            <h5>{{__('messages.gioithieu2')}}</h5>
            <p>{{__('messages.motagioithieu2')}}</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-6" style="flex-shrink: 0;">
        <div class="card service-card">
          <img src="{{ asset('assets') }}/img/phong33.png" class="card-img-top" alt="">
          <div class="card-body text-center">
            <h5>{{__('messages.gioithieu3')}}</h5>
            <p>{{__('messages.motagioithieu3')}}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>



<!-- Dịch vụ nổi bật -->
<section id="featured-services" class="py-4" style="background:#faf7f2;">
  <div class="container">
    <h5 class="text-center text-muted">Woods Spa - 126 Hồ Nghinh</h5>
    <h2 class="text-center fw-bold mb-4 text-uppercase main-color">{{ __('messages.cacdichvu') }}</h2>

    <!-- Swiper -->
    <div class="swiper mySwiper">
      <div class="swiper-wrapper">
        @foreach($categories as $category)
          <div class="swiper-slide mgtb">
            <div class="card shadow border-0">
              <a href="{{ route('service.list') }}?category={{ $category->id }}">
                <img src="{{ asset('storage/' . $category->image) }}" class="card-img-top anh" alt="{{ $category->translated_name }}">
              </a>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</section>


<div class="container my-5">
  <!-- Tabs -->
  <ul class="nav nav-tabs border-0 mb-4" style="overflow-x: auto; display: flex; flex-wrap: nowrap;">
    @foreach($categories as $category)
        <li class="nav-item">
            <a class="nav-link {{ $loop->first ? 'active' : '' }} text-uppercase"
               id="category-{{ $category->id }}-tab"
               data-bs-toggle="tab"
               href="#category-{{ $category->id }}">
               {{ $category->translated_name }}
            </a>
        </li>
    @endforeach
  </ul>

  <div class="tab-content">
    @foreach($categories as $category)
        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="category-{{ $category->id }}">
            <div class="row g-4 mb-4">
                @php
                    $categoryServices = $services->where('category_id', $category->id);
                @endphp

                @foreach($categoryServices->take(3) as $service)
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ asset('storage/' . $service->image) }}" class="card-img-top" alt="Service">
                            <div class="card-body">
                                <h6 class="card-title main-color">{{ $service->translated_name }}</h6>
                                <p class="card-text d-flex align-items-center">
                                    <span class="main-color">{{ $service->duration }}' /</span>
                                    @if ($service->sale_price)
                                        <del class="text-muted ms-1">
                                            @if (app()->getLocale() == 'vi') {{ number_format($service->price, 0, ',', '.') }} 
                                            @else ${{ number_format($service->price, 0, '.', ',') }} @endif
                                        </del>
                                        <span class="fw-bold main-color ms-1">
                                            @if (app()->getLocale() == 'vi') {{ number_format($service->sale_price, 0, ',', '.') }} VND
                                            @else ${{ number_format($service->sale_price, 0, '.', ',') }} @endif
                                        </span>
                                    @else
                                        <span class="fw-bold main-color ms-1">
                                            @if (app()->getLocale() == 'vi') {{ number_format($service->price, 0, ',', '.') }} VND
                                            @else ${{ number_format($service->price, 0, '.', ',') }} @endif
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

            <!-- See all button -->
            <div class="text-center mt-4">
                <a href="{{route('service.list')}}" class="btn btn-primary">{{ __('messages.xemtatca') }}</a>
            </div>
        </div>
    @endforeach
  </div>
</div>


</div>


<!-- YÊU CẦU ĐẶT LỊCH -->
<div class="container my-5">
  <div class="card shadow-sm p-4 no-hover">
    <h4 class="text-center main-color text-uppercase fw-bold">{{__('messages.datlich')}}</h4>
    <p class="text-center text-muted">{{__('messages.motadatlich')}}</p>

    <form action="{{ route('booking.store') }}" method="POST" class="booking-form" id="bookingForm">
      @csrf
      <div class="row g-1 mt-2">

        <!-- Tên + Email -->
        <div class="col-md-6">
          <label class="form-label">{{__('messages.tenkhachhang')}} <span class=" text-danger">*</span></label>
          <input type="text" name="name" class="form-control" placeholder="{{__('messages.vuilongnhap')}}">
          @error('name') <div class="mt-2 text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-6">
          <label class="form-label">Email <span class="text-danger">*</span></label>
          <input type="email" name="email" class="form-control" placeholder="{{__('messages.vuilongnhap')}}">
          @error('email') <div class="mt-2 text-danger">{{ $message }}</div> @enderror
        </div>

        <!-- Phương thức liên lạc -->
        <div class="col-md-6">
          <label class="form-label">{{__('messages.phuongthuclienlac')}}</label>
          <div class="custom-dropdown" data-name="contact_method">
            <div class="selected">{{__('messages.sdt')}}</div>
            <ul class="dropdown-list">
              <li data-value="Số điện thoại">{{__('messages.sdt')}}</li>
              <li data-value="Zalo">Zalo</li>
              <li data-value="WhatsApp">WhatsApp</li>
              <li data-value="Messenger">Messenger</li>
              <li data-value="Line">Line</li>
              <li data-value="KakaoTalk">KakaoTalk</li>
            </ul>
            <input type="hidden" name="contact_method" value="Số điện thoại">
          </div>
        </div>

        <!-- Số điện thoại -->
        <div class="col-md-6">
          <label class="form-label">{{__('messages.sdt')}} <span class="text-danger">*</span></label>
          <input type="tel" name="phone" id="phone" class="form-control" placeholder="{{__('messages.vuilongnhap')}}">
          <input type="hidden" name="country_code" id="countryCode">
          @error('phone') <div class="mt-2 text-danger">{{ $message }}</div> @enderror
        </div>

        <!-- Ngày + Giờ + Số khách -->
        <div class="col-md-4">
          <label class="form-label">{{__('messages.ngay')}} <span class="text-danger">*</span></label>
          <input type="text" id="datePicker" name="date" class="form-control">
          @error('date') <div class="mt-2 text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4">
          <label class="form-label">{{__('messages.gio')}} <span class="text-danger">*</span></label>
          <input type="text" id="timePicker" name="time" class="form-control">
          @error('time') <div class="mt-2 text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4">
          <label class="form-label">{{__('messages.sokhach')}}</label>
          <div class="custom-dropdown" data-name="guestCount">
            <div class="selected">1</div>
            <ul class="dropdown-list">
              @for($i=1; $i<=50; $i++)
                <li data-value="{{ $i }}">{{ $i }}</li>
              @endfor
            </ul>
            <input type="hidden" name="guestCount" id="guestCount" value="1">
          </div>
          @error('guestCount') <div class="mt-2 text-danger">{{ $message }}</div> @enderror
        </div>

        <!-- Ghi chú -->
        <div class="col-12">
          <label class="form-label">{{__('messages.ghichu')}}</label>
          <textarea name="notes" class="form-control" rows="2"></textarea>
        </div>

        <!-- Danh sách khách -->
        <div id="guestList" class="mt-4"></div>

        <!-- Nút đặt lịch -->
        <div class="col-12 mt-3 d-flex justify-content-center">
          <button type="submit" class="btn-auto-shine w-75">{{__('messages.datlichngay')}}</button>
        </div>

      </div>
    </form>
  </div>
</div>

@include('layouts.js_form')

@endsection