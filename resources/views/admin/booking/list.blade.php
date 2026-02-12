@extends('admin.index')

@section('content')
<div class="container mt-4">

    {{-- TIÊU ĐỀ --}}
    <h3 class="fw-bold mb-4">Danh sách đơn đặt</h3>

    {{-- FORM LỌC --}}
    <form method="GET" class="g-2 m-4 filter-form">
        <div class="row justify-content-center ">
            <div class="col-md-3 col-12 mt-3">
                <input type="text" name="keyword" value="{{ request('keyword') }}"
                    class="form-control" placeholder="Tìm theo tên hoặc SĐT...">
            </div>

            <div class="col-md-2 col-6 mt-3" >
                <select name="status"style="height: 40px" class="form-select">
                    <option value="">Tất cả trạng thái</option>
                    <option value="Đã đặt" {{ request('status')=='Đã đặt'?'selected':'' }}>Đã đặt</option>
                    <option value="Đã hoàn thành" {{ request('status')=='Đã hoàn thành'?'selected':'' }}>Đã hoàn thành</option>
                    <option value="Đã hủy" {{ request('status')=='Đã hủy'?'selected':'' }}>Đã hủy</option>
                </select>
            </div>

            <div class="col-md-2 col-6 mt-3">
                <input type="date" name="date" value="{{ request('date') }}" class="form-control">
            </div>
            <div class="col-md-2 col-4 mt-3">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-filter"></i> Lọc
                </button>
            </div>

            <div class="col-md-2 col-4 mt-3">
                <a href="{{ route('admin.booking.list') }}" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-undo"></i> Đặt lại
                </a>
            </div>
        </div>
    </div>
    </form>

    {{-- DANH SÁCH ĐƠN --}}
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th>STT</th>
                    <th>Khách hàng</th>
                    <th>SĐT</th>

                    @php
                        $currentSort = request('sortBy');
                        $currentOrder = request('sortOrder', 'asc');
                        $newOrder = $currentOrder === 'asc' ? 'desc' : 'asc';
                    @endphp

                    <th>
                        <a href="?sortBy=booking_date&sortOrder={{ $currentSort === 'booking_date' ? $newOrder : 'asc' }}"
                           class="text-dark text-decoration-none d-flex justify-content-center align-items-center">
                            Ngày
                            @if($currentSort === 'booking_date')
                                <i class="fas fa-arrow-{{ $currentOrder === 'asc' ? 'up' : 'down' }} ms-1"></i>
                            @endif
                        </a>
                    </th>

                    <th>Giờ đến</th>
                    <th>Số khách</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>

            <tbody>
                @forelse($bookings as $booking)
                {{-- HÀNG CHÍNH --}}
                <tr class="clickable-row"
                    data-bs-toggle="collapse"
                    data-bs-target="#details{{ $booking->id }}"
                    style="cursor:pointer">

                    <td>{{ $loop->iteration + ($bookings->currentPage() - 1) * $bookings->perPage() }}</td>
                    <td>{{ $booking->customer_name }}</td>
                    <td>{{ $booking->customer_phone }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') }}</td>
                    <td>{{ $booking->booking_time }}</td>
                    <td>{{ $booking->number_of_people }}</td>

                    <td>
                        <span class="badge
                            @if($booking->status=='Đã hoàn thành') bg-success
                            @elseif($booking->status=='Đã hủy') bg-danger
                            @else bg-warning text-dark
                            @endif">
                            {{ $booking->status }}
                        </span>
                    </td>

                    <td onclick="event.stopPropagation();">
                        <button class="btn btn-sm btn-primary edit-status-btn"
                                data-id="{{ $booking->id }}"
                                data-status="{{ $booking->status }}"
                                data-bs-toggle="modal"
                                data-bs-target="#editStatusModal">
                                <i class="fas fa-edit"></i>
                        </button>
                    </td>
                </tr>

                {{-- CHI TIẾT --}}
                <tr id="details{{ $booking->id }}" class="collapse bg-light">
                    <td colspan="8">
                        <div class="p-3">

                            <h6 class="fw-bold text-start mb-3">Chi tiết dịch vụ</h6>

                            @if($booking->bookingDetails->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm text-center">
                                    <thead class="table-light">
                                        <tr>
                                            <th>STT</th>
                                            <th>Khách</th>
                                            <th>Dịch vụ</th>
                                            <th>Giá / Thời lượng</th>
                                            <th>Ghi chú</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($booking->bookingDetails as $detail)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $detail->person_name }}</td>

                                            <td>{{ $detail->serviceOption->service->translations->firstWhere('language.code','vi')->name ?? 'Không rõ' }}</td>

                                            <td>
                                                @php
                                                    $op = $detail->serviceOption;
                                                    $finalPrice = $op->sale_price_vnd > 0 ? $op->sale_price_vnd : $op->price_vnd;
                                                @endphp

                                                {{ $op->duration }}' /
                                                {{ number_format($finalPrice, 0, ',', '.') }} VND
                                            </td>

                                            <td>{{ $detail->note ?: '—' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                                <p class="text-muted">Không có dịch vụ nào.</p>
                            @endif

                        </div>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="8" class="text-muted">Không có đơn đặt nào.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PHÂN TRANG --}}
    <div class="mt-3">
        {{ $bookings->appends(request()->query())->links() }}
    </div>
</div>

<div class="modal fade" id="editStatusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg">

            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Cập nhật trạng thái đơn đặt</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <input type="hidden" id="bookingId">

                <label class="fw-bold mb-2">Trạng thái</label>
                <select id="statusSelectModal" class="form-select">
                    <option value="Đã đặt">Đã đặt</option>
                    <option value="Đã hoàn thành">Đã hoàn thành</option>
                    <option value="Đã hủy">Đã hủy</option>
                </select>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button class="btn btn-primary" id="saveStatusBtn">Lưu thay đổi</button>
            </div>

        </div>
    </div>
</div>

{{-- SCRIPT --}}
<script>
let bookingIdToUpdate = null;

// Gán giá trị vào modal khi nhấn nút sửa
document.querySelectorAll('.edit-status-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        bookingIdToUpdate = this.dataset.id;
        document.getElementById("statusSelectModal").value = this.dataset.status;
    });
});

document.getElementById("saveStatusBtn").addEventListener("click", function () {
    const newStatus = document.getElementById("statusSelectModal").value;

    fetch(`/admin/bookings/${bookingIdToUpdate}/update-status`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ status: newStatus }),
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) location.reload();
            else alert("❌ Lỗi khi cập nhật trạng thái.");
        })
        .catch(() => alert("⚠️ Có lỗi xảy ra."));
});
</script>
<style>
    .filter-form .btn {
        padding: 0.65rem 0.4rem;
    }

    @media (max-width: 576px) {
        .filter-form .btn {
            padding: 0.55rem 0.35rem;
            font-size: 14px;
        }
    }
</style>

@endsection
