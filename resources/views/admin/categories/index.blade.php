@extends('admin.index')

@section('content')
<style>
    .table-custom {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
    }

    .table-custom tbody tr {
        background-color: #f2f2f2;
    }

    .table-custom tbody td {
        background-color: #ffffff;
    }

    .table-custom th,
    .table-custom td {
        border: 1px solid #dee2e6;
        vertical-align: middle;
    }

    .table-custom thead th {
        background-color: #e0e0e0;
        color: #333;
        text-transform: uppercase;
    }
</style>

<div class="container">
    <div class="d-flex align-items-center flex-column flex-md-row pt-3 pb-4">
        <h3 class="fw-bold mb-3">Danh sách danh mục</h3>
        <a href="{{ route('admin.categories.create') }}" class="ms-auto btn btn-success">
            Thêm mới danh mục
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-custom">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Ảnh</th>
                    <th>Tên</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($category->image)
                                <div class="image-wrapper">
                                    <img src="{{ asset('storage/' . $category->image) }}"
                                         alt="Image"
                                         width="120px"
                                         height="120px"
                                         class="img-fluid">
                                </div>
                            @else
                                <span class="text-muted">Không có ảnh</span>
                            @endif
                        </td>
                        <td class="category-name">
                            @foreach($category->translations as $translation)
                                <span class="me-3 d-inline-block">
                                    <strong style="text-transform: uppercase;">{{ $translation->language->code }}:</strong> {{ $translation->name }}
                                </span>
                            @endforeach
                        </td>
                        <td>
                            <span>{{ $category->status == 1 ? 'Hoạt động' : 'Không hoạt động' }}</span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning btn-sm me-2">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">
                                        <i class="fas fa-trash"></i> Xóa
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
