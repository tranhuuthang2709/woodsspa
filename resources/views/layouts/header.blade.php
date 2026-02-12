@php
    $languages = config('locales.supported');
    $currentLocale = app()->getLocale();
    $current = $languages[$currentLocale] ?? $languages[config('locales.default')];
@endphp

<nav class="navbar navbar-expand-lg fixed-top shadow-sm py-3 bg">
  <div class="container">
    <!-- Logo -->
    <a class="navbar-brand fw-bold text-dark" href="{{ url('/') }}">
      <!-- Logo mobile -->
      <img src="{{ asset('assets/img/logomin.svg') }}" alt="Mahaspa Mobile" class="d-lg-none">
      <!-- Logo desktop -->
      <img src="{{ asset('assets/img/logomax.svg') }}" alt="Mahaspa Desktop" class="d-none d-lg-block">
    </a>

    <!-- Language dropdown (mobile) -->
    <div class="dropdown ms-auto d-lg-none me-3">
      <a class="btn btn-light dropdown-toggle d-flex align-items-center" href="#" id="langDropdown" data-bs-toggle="dropdown">
        <img src="{{ $current['flag'] }}" class="me-1"> {{ $current['name'] }}
      </a>
      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="langDropdown">
        @foreach($languages as $key => $lang)
          <li>
            <a class="dropdown-item d-flex align-items-center" href="{{ route('set.language', $key) }}">
              <img src="{{ $lang['flag'] }}" class="me-1"> {{ $lang['name'] }}
            </a>
          </li>
        @endforeach
      </ul>
    </div>

    <!-- Nút menu mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu -->
    <div class="collapse navbar-collapse" id="menu">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('home') ? 'active fw-bold text-dark' : '' }}" 
              href="{{route('home')}}">{{ __('messages.trangchu') }}</a>
          </li>

          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('about') ? 'active fw-bold text-dark' : '' }}" 
              href="{{route('about')}}">{{ __('messages.vechungtoi') }}</a>
          </li>

          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('service.list') ? 'active fw-bold text-dark' : '' }}" 
              href="{{route('service.list')}}">{{ __('messages.dichvu') }}</a>
          </li>

          {{-- <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('blog*') ? 'active fw-bold text-dark' : '' }}" 
              href="#">{{ __('messages.baiviet') }}</a>
          </li> --}}

          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('contact') ? 'active fw-bold text-dark' : '' }}" 
              href="{{route('contact')}}">{{ __('messages.lienhe') }}</a>
          </li>
        </ul>

    </div>

    <div class="d-none d-lg-flex align-items-center">
      <div class="dropdown me-3">
        <a class="btn btn-light dropdown-toggle d-flex align-items-center" href="#" id="langDropdownDesktop" data-bs-toggle="dropdown">
          <img src="{{ $current['flag'] }}" class="me-1"> {{ $current['name'] }}
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="langDropdownDesktop">
          @foreach($languages as $key => $lang)
            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{ route('set.language', $key) }}">
                <img src="{{ $lang['flag'] }}" class="me-1"> {{ $lang['name'] }}
              </a>
            </li>
          @endforeach
        </ul>
      </div>

      <a href="{{route('booking.index')}}" class="btn fw-semibold px-3" style="background:#7C3821;color:#fff;">
        <i class="bi bi-calendar-check me-1"></i> {{ __('messages.datlichngay') }}
      </a>
    </div>
  </div>
</nav>
