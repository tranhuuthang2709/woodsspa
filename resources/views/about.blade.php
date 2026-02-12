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

{{-- Giới thiệu 1 --}}
<section class="py-5 bg">
  <div class="container">
    <div class="row align-items-center  ">
      <div class="col-lg-6 mb-4">
        <img src="{{ asset('assets/img/phong11.png') }}" class="img-fluid rounded-4 shadow" alt="">
      </div>
      <div class="col-lg-6">
        <h2 class="main-color fw-bold mb-3 text-uppercase">{{__('messages.sumanhcuachungtoi')}}</h2>
        <p class="text-muted mb-4" style="line-height:1.9;">
          {{__('messages.motaabout')}}
        </p>
        <p class="text-muted mb-4" style="line-height:1.9;">
          {{__('messages.motaabout1')}}
        </p>
        <div class="d-flex justify-content-center">
          <a href="{{ route('service.list') }}" class="btn btn-primary px-4 py-2">{{__('messages.khamphadichvu')}}</a>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- Giới thiệu 2 --}}
<section class="py-5 bg">
  <div class="container">
    <div class="row align-items-center flex-lg-row-reverse">
      <div class="col-lg-6 mb-4">
        <img src="{{ asset('assets/img/phong22.png') }}" class="img-fluid rounded-4 shadow" alt="Không gian thư giãn ">
      </div>
      <div class="col-lg-6">
        <h2 class="main-color fw-bold mb-3 text-uppercase">{{__('messages.trainghiemhoanhao')}}</h2>
        <p class="text-muted mb-4" style="line-height:1.9;">
          {{__('messages.motaabout2')}}
        </p>
        <p class="text-muted mb-4" style="line-height:1.9;">
          {{__('messages.motaabout3')}}
        </p>
        <div class="d-flex justify-content-center">
          <a href="{{ route('booking.index') }}" class="btn btn-primary px-4 py-2">{{__('messages.datlichngay')}}</a>
        </div>
      </div>
    </div>
  </div>
</section>

 <!-- Wrapper có khả năng cuộn ngang -->
    <div class="row g-4 flex-nowrap overflow-auto mx-0">
      <div class="col-md-4 col-6" style="flex-shrink: 0; min-width: 350px;">
        <div class="card service-card">
          <img src="{{ asset('assets') }}/img/phong22.png" class="card-img-top" alt="">
          <div class="card-body text-center">
            <h5>{{__('messages.gioithieu1')}}</h5>
            <p>{{__('messages.motagioithieu1')}}</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-6" style="flex-shrink: 0; min-width: 350px;">
        <div class="card service-card">
          <img src="{{ asset('assets') }}/img/phong11.png" class="card-img-top" alt="">
          <div class="card-body text-center">
            <h5>{{__('messages.gioithieu2')}}</h5>
            <p>{{__('messages.motagioithieu2')}}</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-6" style="flex-shrink: 0; min-width: 350px;">
        <div class="card service-card">
          <img src="{{ asset('assets') }}/img/phong33.png" class="card-img-top" alt="">
          <div class="card-body text-center">
            <h5>{{__('messages.gioithieu3')}}</h5>
            <p>{{__('messages.motagioithieu3')}}</p>
          </div>
        </div>
      </div>
    </div>

{{-- Cam kết chất lượng --}}
<section class="py-5 bg">
  <div class="container">
    <h2 class="text-center main-color fw-bold mb-5 text-uppercase">{{__('messages.camket')}}</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card border-0 shadow-sm text-center h-100 p-4">
          <i class="bi bi-flower1 display-5 main-color mb-3"></i>
          <h5 class="fw-bold mb-2">{{__('messages.tieudecamket1')}}</h5>
          <p class="text-muted small" style="line-height: 1.7;">
            {{__('messages.motacamket1')}}
          </p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 shadow-sm text-center h-100 p-4">
          <i class="bi bi-heart-pulse display-5 main-color mb-3"></i>
          <h5 class="fw-bold mb-2">{{__('messages.tieudecamket2')}}</h5>
          <p class="text-muted small" style="line-height: 1.7;">
            {{__('messages.motacamket2')}}
          </p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 shadow-sm text-center h-100 p-4">
          <i class="bi bi-stars display-5 main-color mb-3"></i>
          <h5 class="fw-bold mb-2">{{__('messages.tieudecamket3')}}</h5>
          <p class="text-muted small" style="line-height: 1.7;">
            {{__('messages.motacamket3')}}
          </p>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
