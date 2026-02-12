@extends('admin.index')

@section('content')
<style>
    /* ====== Tùy chỉnh bảng dịch vụ ====== */
    .table-custom {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
    }

    /* Nền xám nhạt cho từng dòng */
    .table-custom tbody tr {
        background-color: #f2f2f2; /* xám nhạt */
    }

    /* Nền trắng cho các ô */
    .table-custom tbody td {
        background-color: #ffffff; /* trắng */
    }

    /* Header */
    .table-custom thead th {
        background-color: #e0e0e0;
        color: #333;
        text-transform: uppercase;
        font-weight: 600;
    }

    /* Viền nhẹ */
    .table-custom th,
    .table-custom td {
        border: 1px solid #dee2e6;
        vertical-align: middle;
    }

    /* Hiệu ứng hover nhẹ */
    .table-custom tbody tr:hover td {
        background-color: #e9ecef;
    }
</style>

<div class="container">
    <!-- Header -->
    <div class="d-flex align-items-center flex-column flex-md-row pt-3 pb-4">
        <h3 class="fw-bold mb-3">Danh sách dịch vụ</h3>
        <a href="{{ route('admin.services.create') }}" class="ms-auto btn btn-success">
            Thêm mới dịch vụ
        </a>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <!-- Bỏ table-striped để không bị xen kẽ -->
        <table class="table table-bordered table-custom">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Ảnh</th>
                    <th>Tên</th>
                    <th>Danh mục</th>
                    <th>Giá</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($services as $service)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($service->image)
                                <div class="image-wrapper">
                                    <img src="{{ asset('storage/' . $service->image) }}"
                                         alt="Image"
                                         width="120px"
                                         height="120px"
                                         class="img-fluid">
                                </div>
                            @else
                                <span class="text-muted">Không có ảnh</span>
                            @endif
                        </td>
                        <td class="service-name">
                            @php
                                $viTranslation = $service->translations->firstWhere('language.code', 'vi');
                            @endphp
                            @if($viTranslation)
                                <span class="me-3 d-inline-block text-uppercase">
                                    {{ $viTranslation->name }}
                                </span>
                            @endif
                        </td>

                        <td>
                            {{ $service->category->translations->first()->name ?? '' }}
                        </td>
                        <td>
                            @foreach($service->options as $opt)
                                <span class="d-block">
                                    {{ $opt->duration }} phút -
                                    {{ number_format($opt->price_vnd, 0, ',', '.') }}đ /
                                    ${{ $opt->price_usd }}
                                </span>
                            @endforeach
                        </td>
                        <td>
                            <span>
                                {{ $service->status == 1 ? 'Hoạt động' : 'Không hoạt động' }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-warning btn-sm me-2">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Xoá dịch vụ này?')">
                                        <i class="fas fa-trash"></i> Xoá
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
