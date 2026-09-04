@extends('index')
@section('content')
<header>
  @include('layouts.header')
</header>

<div class="container my-5">
    @if (session('success'))
        <div class="booking-toast booking-toast-success" id="bookingToast">
            <div class="toast-icon">
                ✓
            </div>

            <div class="toast-content">
                <div class="toast-title">
                    Thành công
                </div>

                <div class="toast-message">
                    {{ session('success') }}
                </div>
            </div>

            <button type="button"
                    class="toast-close"
                    onclick="closeBookingToast()">
                &times;
            </button>
        </div>
    @endif


    @if ($errors->any())
        <div class="booking-toast booking-toast-error" id="bookingToast">

            <div class="toast-icon">
                !
            </div>

            <div class="toast-content">
                <div class="toast-title">
                    {{ __('messages.booking_failed') }}
                </div>

                <div class="toast-message">
                    {{ $errors->first() }}
                </div>
            </div>

            <button type="button"
                    class="toast-close"
                    onclick="closeBookingToast()">
                &times;
            </button>

        </div>
    @endif

  <div class="card shadow-sm p-4 no-hover">
    <h4 class="text-center main-color text-uppercase fw-bold">{{__('messages.datlich')}}</h4>
    <p class="text-center text-muted">{{__('messages.motadatlich')}}</p>

    <form action="{{ route('booking.store') }}" method="POST" class="booking-form" id="bookingForm">
      @csrf
      <div class="row g-1 mt-2">

        <!-- Tên + Email -->
        <div class="col-md-6">
          <label class="form-label">{{__('messages.tenkhachhang')}} <span class=" text-danger">*</span></label>
          <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="{{__('messages.vuilongnhap')}}">
          @error('name') <div class="mt-2 text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-6">
          <label class="form-label">Email <span class="text-danger">*</span></label>
          <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="{{__('messages.vuilongnhap')}}">
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
          <input type="tel" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" placeholder="{{__('messages.vuilongnhap')}}">
          <input type="hidden" name="country_code" id="countryCode">
          @error('phone') <div class="mt-2 text-danger">{{ $message }}</div> @enderror
        </div>

        <!-- Ngày + Giờ + Số khách -->
        <div class="col-md-4">
          <label class="form-label">{{__('messages.ngay')}} <span class="text-danger">*</span></label>
          <input type="text" id="datePicker" name="date"  class="form-control" value="{{ old('date') }}">
          @error('date') <div class="mt-2 text-danger">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-4">
          <label class="form-label">{{__('messages.gio')}} <span class="text-danger">*</span></label>
          <input type="text" id="timePicker" name="time" class="form-control" value="{{ old('time') }}">
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
            <input type="hidden" name="guestCount" id="guestCount"  value="{{ old('guestCount') ?? 1 }}">
          </div>
          @error('guestCount') <div class="mt-2 text-danger">{{ $message }}</div> @enderror
        </div>

        <!-- Ghi chú -->
        <div class="col-12">
          <label class="form-label">{{__('messages.ghichu')}}</label>
          <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
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
