@extends('admin.index')

@section('content')
    <div class="container">
        <h1>Thêm mới danh mục</h1>

        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="px-4">
            @csrf
            <div class="row"> 
                <div class="form-group col-md-6">
                    <label for="image">Ảnh</label>
                    <input type="file" name="image" id="image" class="form-control" onchange="previewImage(event)" />
                      <div id="imagePreviewContainer" class="mt-2">
                        <img id="imagePreview" src="" alt="Image Preview" style="max-width: 150px; max-height: 150px; object-fit: cover; display: none; border: 1px solid #ddd; padding: 5px;" />
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label for="status">Trạng thái</label>
                    <select name="status" id="status" class="form-control">
                        <option value="1">Hoạt động</option>
                        <option value="0">Không hoạt động</option>
                    </select>
                </div>

            </div>

              <div class="row">
                @foreach($languages as $language)
                    <div class="form-group col-md-4">
                        <label for="name[{{ $language->id }}]">Tên ({{ $language->name }})</label>
                        <input type="text" name="name[{{ $language->id }}]" id="name[{{ $language->id }}]" class="form-control" />
                    </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-success mt-3 d-block mx-auto">Lưu</button>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const file = event.target.files[0]; 
            const reader = new FileReader();
            const preview = document.getElementById('imagePreview');
            
            if (file) {
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block'; 
                };
                reader.readAsDataURL(file); 
            } else {
                preview.style.display = 'none';
            }
        }
    </script>
@endsection
