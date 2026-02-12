@extends('index')

@section('content')
<header>
    @include('layouts.header')
</header>

<div class="container my-5 ">
    <a href="{{ url()->previous() }}" class="text-decoration-none mb-3 d-inline-block main-color">
        <i class="bi bi-arrow-left-circle"></i> {{ __('messages.quaylai') }}
    </a>

    <div class="row">
        <div class="col-md-6 mb-4">
            <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->translated_name }}" class="img-fluid rounded shadow">
        </div>
        <div class="col-md-6">
            <h2 class="fw-bold main-color">{{ $service->translated_name }}</h2>
            <div class="mt-2">
                @foreach($options as $option)
                    <p class="card-text d-flex align-items-center mb-1">
                        <span class="me-1">{{ $option->duration }}' /</span>
                        @if(app()->getLocale() == 'vi')
                            @if($option->sale_price_vnd)
                                <del class="text-muted ms-1">{{ number_format($option->price_vnd, 0, ',', '.') }}</del>
                                <span class="fw-bold main-color ms-1">{{ number_format($option->sale_price_vnd, 0, ',', '.') }} VND</span>
                            @else
                                <span class="fw-bold main-color ms-1">{{ number_format($option->price_vnd, 0, ',', '.') }} VND</span>
                            @endif
                        @else
                            @if($option->sale_price_usd)
                                <del class="text-muted ms-1">${{ number_format($option->price_usd, 0, '.', ',') }}</del>
                                <span class="fw-bold main-color ms-1">${{ number_format($option->sale_price_usd, 0, '.', ',') }}</span>
                            @else
                                <span class="fw-bold main-color ms-1">${{ number_format($option->price_usd, 0, '.', ',') }}</span>
                            @endif
                        @endif
                    </p>
                @endforeach
            </div>
            @if(!empty($service->description))
                <p >
                    {{($service->translated_description)}}
                </p>
            @endif
             <p >
                {{($service->translated_description)}}
            </p>
            <p><i class="bi bi-clock-fill text-warning"></i> 9:00 - 23:00 {{ __('messages.tatcacacngay') }}</p>
            <p><i class="bi bi-geo-alt-fill text-danger"></i> Woods Spa - 126 Hồ Nghinh, Đà Nẵng</p>


            <a class="btn btn-primary px-4 mt-3" href="#">
                {{ __('messages.datlichngay') }}
            </a>
        </div>
    </div>

    <div class="mt-5">
        <h4 class="mb-4 main-color">{{ __('messages.dichvulienquan') }}</h4>
        <div class="row g-4">
            @foreach($services_related->take(3) as $related)
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset('storage/' . $related->image) }}" class="card-img-top" alt="{{ $related->translated_name }}">
                        <div class="card-body">
                            <h6 class="card-title main-color">{{ $related->translated_name }}</h6>
                            <p class="card-text d-flex align-items-center">
                                <span class="main-color">{{ $related->duration }}' /</span>
                                @if ($related->sale_price)
                                    <del class="text-muted ms-1">
                                        @if(app()->getLocale() == 'vi')
                                            {{ number_format($related->price, 0, ',', '.') }}
                                        @else
                                            ${{ number_format($related->price, 0, '.', ',') }}
                                        @endif
                                    </del>
                                    <span class="fw-bold main-color ms-1">
                                        @if(app()->getLocale() == 'vi')
                                            {{ number_format($related->sale_price, 0, ',', '.') }} VND
                                        @else
                                            ${{ number_format($related->sale_price, 0, '.', ',') }}
                                        @endif
                                    </span>
                                @else
                                    <span class="fw-bold main-color ms-1">
                                        @if(app()->getLocale() == 'vi')
                                            {{ number_format($related->price, 0, ',', '.') }} VND
                                        @else
                                            ${{ number_format($related->price, 0, '.', ',') }}
                                        @endif
                                    </span>
                                @endif
                            </p>
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('service.detail', $related->id) }}" class="btn btn-primary rounded-circle shadow-sm">
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
