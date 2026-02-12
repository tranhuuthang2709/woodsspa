@extends('admin.index')

@section('content')
    <div class="container">
        <h1>Chỉnh sửa Category</h1>

        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data" class="px-4">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="image">Ảnh</label>
                    <input type="file" name="image" id="image" class="form-control" onchange="previewImage(event)" />
                    
                    @if($category->image)
                        <div id="currentImage" class="mt-3">
                            <p><strong>Ảnh hiện tại:</strong></p>
                            <img src="{{ asset('storage/' . $category->image) }}" width="100" id="imagePreview" />
                        </div>
                    @else
                        <p>Không có ảnh hiện tại.</p>
                    @endif
                    <div id="newImagePreviewContainer" class="mt-3" style="display: none;">
                        <p><strong>Ảnh mới:</strong></p>
                        <img id="newImagePreview" width="100" />
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label for="status">Trạng thái</label>
                    <select name="status" id="status" class="form-control">
                        <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>Hoạt động</option>
                        <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>Không hoạt động</option>
                    </select>
                </div>
            </div>

            <div class="row">
                @foreach($languages as $language)
                    <div class="form-group col-md-4">
                        <label for="name[{{ $language->id }}]">Tên ({{ $language->name }})</label>
                        <input type="text" name="name[{{ $language->id }}]" value="{{ $category->translations->where('language_id', $language->id)->first()->name ?? '' }}" class="form-control" />
                    </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-success mt-3 d-block mx-auto">Cập nhật</button>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const reader = new FileReader();
            const preview = document.getElementById('newImagePreview');
            const newImagePreviewContainer = document.getElementById('newImagePreviewContainer');
            const currentImage = document.getElementById('currentImage');
            
            if (file) {
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    newImagePreviewContainer.style.display = 'block'; 
                    currentImage.style.display = 'none'; 
                };
                reader.readAsDataURL(file);
            } else {
                newImagePreviewContainer.style.display = 'none'; 
            }
        }
    </script>
@endsection
