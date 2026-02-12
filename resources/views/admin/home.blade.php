@extends('admin.index')

@section('content')
<div class="page-inner">

    {{-- Tiêu đề --}}
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <div>
            <h3 class="fw-bold mb-3">Trang chủ</h3>
            <h6 class="op-7 mb-2">Thống kê</h6>
        </div>
    </div>

    {{-- Cards thống kê --}}
    <div class="row">
        {{-- Dịch vụ --}}
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                                <i class="fas fa-concierge-bell"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Dịch vụ</p>
                                <h4 class="card-title">{{ $serviceCount }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Đơn đặt --}}
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-info bubble-shadow-small">
                                <i class="fas fa-user-check"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Đơn đặt</p>
                                <h4 class="card-title">{{ $bookingCount }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Đơn hoàn thành --}}
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                <i class="far fa-check-circle"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Đơn hoàn thành</p>
                                <h4 class="card-title">{{ $completedBookingCount }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Biểu đồ --}}
    <div class="row mt-4">
        {{-- Line chart đơn đặt theo ngày --}}
        <div class="col-md-8">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-title">Đơn đặt theo tháng</div>
                </div>
                <div class="card-body">
                    <canvas id="bookingChart" style="height: 350px;"></canvas>
                </div>
            </div>
        </div>

        {{-- Doughnut chart tỷ lệ trạng thái --}}
        <div class="col-md-4">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-title">Tỷ lệ trạng thái đơn</div>
                </div>
                <div class="card-body">
                    <canvas id="statusChart" style="height: 350px;"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- jsVectorMap -->
<script src="{{ asset('js/jsvectormap.min.js') }}"></script>
<script src="{{ asset('js/jsvectormap.world.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var bookingCanvas = document.getElementById('bookingChart');
    if (bookingCanvas) {
        new Chart(bookingCanvas.getContext('2d'), {
            type: 'line',
            data: {
                labels: ['1','2','3','4','5','6','7','8','9','10','11','12'],
                datasets: [{
                    label: "Số đơn",
                    data: {!! json_encode($chartData) !!},
                    borderColor: "#1d7af3",
                    backgroundColor: "rgba(29,122,243,0.2)",
                    fill: true,
                    tension: 0.3,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: true } },
                scales: {
                    x: { title: { display: true, text: 'Tháng trong năm' } },
                    y: { 
                        beginAtZero: true,
                        title: { display: true, text: 'Số đơn' },
                        ticks: {
                            stepSize: 1, // Bước nhảy = 1 để chỉ hiển thị số nguyên
                            callback: function(value) { return Number(value); }
                        }
                      }
                    }
            }
        });
    }

    // ----- Doughnut chart tỷ lệ trạng thái -----
    var statusCanvas = document.getElementById('statusChart');
    if (statusCanvas) {
        var statusLabels = {!! json_encode(array_keys($statusCounts)) !!};
        var statusData   = {!! json_encode(array_values($statusCounts)) !!};

        new Chart(statusCanvas.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusData,
                    backgroundColor: ['#1d7af3', '#28a745', '#dc3545'],
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    }

    // ----- jsVectorMap -----
    const mapEl = document.getElementById('worldMap');
    if (mapEl) {
        new jsVectorMap({
            selector: "#worldMap",
            map: "world_merc",
            zoomButtons: true,
            markers: [
                { name: "Hà Nội", coords: [21.028511, 105.804817] },
                { name: "TP.HCM", coords: [10.762622, 106.660172] },
            ],
            markerStyle: {
                initial: { fill: '#FF6B6B' }
            },
            regionStyle: {
                initial: { fill: '#e4e4e4' }
            }
        });
    }
});
</script>
@endpush
