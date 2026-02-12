@extends('admin.index')

@section('content')
<div class="container mt-4">

    <h3 class="fw-bold mb-4">Quản lý Banner</h3>

    {{-- Upload banner mới --}}
    <form action="{{ route('admin.banner.upload') }}" method="POST" enctype="multipart/form-data" class="mb-4 row g-2 align-items-end">
        @csrf
        <div class="col-md-6">
            <label class="form-label fw-bold">Thêm banner mới</label>
            <input type="file" name="image" class="form-control" required>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">Tải lên</button>
        </div>
    </form>

    {{-- Danh sách banner --}}
    <div class="row">
        @foreach($banners as $banner)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <img src="{{ asset('storage/' . $banner->image) }}" class="card-img-top" style="height:200px; object-fit:cover;">

                <div class="card-body d-flex justify-content-between text-center gap-4">
                    {{-- Hiển thị/Ẩn --}}
                    <form action="{{ route('admin.banner.toggle', $banner->id) }}" method="POST" class="flex-fill">
                        @csrf
                        <button type="submit" class="btn btn-{{ $banner->active ? 'success' : 'secondary' }} w-100">
                            {{ $banner->active ? 'Đang hiển thị' : 'Ẩn' }}
                        </button>
                    </form>

                    {{-- Thay đổi --}}
                    <form action="{{ route('admin.banner.update', $banner->id) }}" method="POST" enctype="multipart/form-data" class="flex-fill mb-0">
                        @csrf
                        @method('PUT')
                        <input type="file" name="image" class="d-none" id="updateBanner{{ $banner->id }}" onchange="this.form.submit()">
                        <button type="button" class="btn btn-warning w-100" onclick="document.getElementById('updateBanner{{ $banner->id }}').click()">
                            Thay đổi
                        </button>
                    </form>

                    {{-- Xóa --}}
                    <form action="{{ route('admin.banner.delete', $banner->id) }}" method="POST" class="flex-fill" onsubmit="return confirm('Bạn có chắc muốn xóa banner này?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">Xóa</button>
                    </form>
                </div>

            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection
