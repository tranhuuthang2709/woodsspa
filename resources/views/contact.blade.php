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

<section class="py-5 bg">
  <div class="container">
    <div class="row g-4 align-items-stretch mt-3">
      <div class="col-lg-6 col-12 d-flex flex-column">
        <div class="p-4 rounded-4 shadow-sm mb-4 " style="background-color: #fdeee5;font-size:18px">
          <h5 class="fw-bold text-uppercase main-color mb-2">Woods Spa - Đà Nẵng</h5>
          <h3 class="fw-bold main-color mb-3">{{__('messages.tieudecontact')}}</h3>
          <p class="text-muted mb-0" >
            {{__('messages.motacontact')}}
          </p>
        </div>

        <div class="p-4 rounded-4 shadow-sm bg-white" style="font-size:18px">
          <h5 class="fw-bold main-color mb-3 text-uppercase">{{__('messages.thongtinlienhe')}}</h5>
          <p class="mb-2"><i class="bi bi-calendar-check me-2 main-color"></i>{{__('messages.thoigianhoatdong')}}: 09:00 AM - 23:00 PM</p>
          <p class="mb-2"><i class="bi bi-geo-alt me-2 main-color"></i>{{__('messages.diachi')}}: 126 Hồ Nginh, Sơn Trà, Đà Nẵng</p>
          <p class="mb-2"><i class="bi bi-telephone me-2 main-color"></i>{{__('messages.sdt')}}: 0704061229 - 0905999089</p>
          <p class="mb-0"><i class="bi bi-envelope me-2 main-color"></i>Email: woodsspa126@gmail.com</p>
        </div>
      </div>

      {{-- Cột phải --}}
      <div class="col-lg-6 col-12 d-flex">
        <div class="p-4 bg-white rounded-4 shadow-sm flex-fill w-100 h-100">
          <h3 class="fw-bold main-color mb-4 text-uppercase">{{__('messages.lienhevoichungtoi')}}</h3>
          <form method="post" action="{{ route('contact.send') }}" >
            @csrf
            <div>
              <div class="mb-3">
                <label class="form-label fw-semibold">{{__('messages.tenkhachhang')}} <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control form-control-lg rounded-3" placeholder="{{__('messages.vuilongnhap')}}" >
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-3">
                <label class="form-label fw-semibold">{{__('messages.phuongthuclienlac')}} </label>
                <select class="form-select"name="contact_method">
                    <option value="Số điện thoại"selected>{{__('messages.sdt')}} </option>
                    <option value="Zalo">Zalo</option>
                    <option value="WhatsApp">WhatsApp</option>
                    <option value="Messenger">Messenger</option>
                    <option value="Line">Line</option>
                    <option value="KakaoTalk">KakaoTalk</option>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label fw-semibold">{{__('messages.sdt')}} <span class="text-danger">*</span></label>
                <input type="tel" name="phone" id="phone" class="form-control form-control-lg rounded-3" placeholder="{{__('messages.vuilongnhap')}}">
                @error('phone')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

              <div class="mb-3">
                <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control form-control-lg rounded-3" placeholder="{{__('messages.vuilongnhap')}}" >
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-3">
                <label class="form-label fw-semibold">{{__('messages.noidung')}} <span class="text-danger">*</span></label>
                <textarea name="content" class="form-control form-control-lg rounded-3" rows="4" placeholder="{{__('messages.vuilongnhap')}}" ></textarea>
                @error('content')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <button type="submit" class="btn-auto-shine fw-semibold px-4 py-2 rounded-3 w-100 ">
              {{__('messages.gui')}}
            </button>
          </form>
        </div>
      </div>

    </div>
  </div>
</section>
@endsection
