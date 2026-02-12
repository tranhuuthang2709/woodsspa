@extends('admin.index')

@section('content')
<div class="container">
    <h3>Thêm dịch vụ</h3>

    <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Ảnh dịch vụ + Danh mục + Trạng thái --}}
        <div class="row mb-3">
            {{-- Ảnh dịch vụ --}}
            <div class="col-md-4">
                <label class="form-label">Ảnh dịch vụ</label>
                <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event)">
                <img id="preview" 
                     src="{{ isset($service) && $service->image ? asset('storage/'.$service->image) : '' }}" 
                     class="mt-2 img-thumbnail" 
                     style="max-height:150px; {{ isset($service) && $service->image ? '' : 'display:none;' }}">
            </div>

            {{-- Danh mục --}}
            <div class="col-md-4">
                <label class="form-label">Danh mục</label>
                <select name="category_id" class="form-control" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" 
                            {{ isset($service) && $service->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->translations->first()->name ?? 'No Name' }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Trạng thái --}}
            <div class="col-md-4">
                <label class="form-label">Trạng thái</label>
                <select name="status" class="form-control">
                    <option value="1" {{ isset($service) && $service->status == 1 ? 'selected' : '' }}>Hoạt động</option>
                    <option value="0" {{ isset($service) && $service->status == 0 ? 'selected' : '' }}>Không hoạt động</option>
                </select>
            </div>
        </div>

        {{-- Thông tin dịch vụ theo ngôn ngữ --}}
        <h5 class="mt-3">Thông tin dịch vụ theo ngôn ngữ</h5>
        @foreach($languages as $lang)
            <div class="row mb-2">
                <div class="col-md-4">
                    <label class="form-label small">Tên ({{ $lang->name }})</label>
                    <input type="text" 
                           name="name[{{ $lang->id }}]" 
                           value="{{ isset($service) ? ($service->translations->where('language_id',$lang->id)->first()->name ?? '') : '' }}" 
                           class="form-control">
                </div>
                <div class="col-md-8">
                    <label class="form-label small">Mô tả ({{ $lang->name }})</label>
                    <input type="text" 
                           name="description[{{ $lang->id }}]" 
                           value="{{ isset($service) ? ($service->translations->where('language_id',$lang->id)->first()->description ?? '') : '' }}" 
                           class="form-control">
                </div>
            </div>
        @endforeach

        {{-- Các gói dịch vụ --}}
        <h5 class="mt-3">Các gói dịch vụ (duration + giá)</h5>
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Danh sách gói</span>
                <button type="button" class="btn btn-sm btn-primary" onclick="addOption()">+ Thêm gói</button>
            </div>
            <div class="card-body" id="options-wrapper">
                <div class="row g-2 align-items-end mb-2 option-item">
                    <div class="col-md-2">
                        <input type="number" name="options[0][duration]" class="form-control" placeholder="Thời lượng (phút)" required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="options[0][price_vnd]" class="form-control" placeholder="Giá VNĐ">
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="options[0][sale_price_vnd]" class="form-control" placeholder="Giá KM VNĐ">
                    </div>
                    <div class="col-md-2">
                        <input type="number" step="0.01" name="options[0][price_usd]" class="form-control" placeholder="Giá USD">
                    </div>
                    <div class="col-md-2">
                        <input type="number" step="0.01" name="options[0][sale_price_usd]" class="form-control" placeholder="Giá KM USD">
                    </div>
                    <div class="col-md-2 text-end">
                        <button type="button" class="btn btn-sm btn-danger" onclick="removeOption(this)">X</button>
                    </div>
                </div>
            </div>
        </div>

        <button class="btn btn-success">Lưu</button>
    </form>
</div>

<script>
let optionIndex = 1;

function addOption() {
    let wrapper = document.getElementById('options-wrapper');
    let html = `
    <div class="row g-2 align-items-end mb-2 option-item">
        <div class="col-md-2">
            <input type="number" name="options[${optionIndex}][duration]" class="form-control" placeholder="Thời lượng (phút)" required>
        </div>
        <div class="col-md-2">
            <input type="number" name="options[${optionIndex}][price_vnd]" class="form-control" placeholder="Giá VNĐ">
        </div>
        <div class="col-md-2">
            <input type="number" name="options[${optionIndex}][sale_price_vnd]" class="form-control" placeholder="Giá KM VNĐ">
        </div>
        <div class="col-md-2">
            <input type="number" step="0.01" name="options[${optionIndex}][price_usd]" class="form-control" placeholder="Giá USD">
        </div>
        <div class="col-md-2">
            <input type="number" step="0.01" name="options[${optionIndex}][sale_price_usd]" class="form-control" placeholder="Giá KM USD">
        </div>
        <div class="col-md-2 text-end">
            <button type="button" class="btn btn-sm btn-danger" onclick="removeOption(this)">X</button>
        </div>
    </div>`;
    wrapper.insertAdjacentHTML('beforeend', html);
    optionIndex++;
}

function removeOption(button) {
    button.closest('.option-item').remove();
}

function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
        const output = document.getElementById('preview');
        output.src = reader.result;
        output.style.display = 'block';
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection
