@extends('admin.index')

@section('content')

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">

                    <h4 class="fw-bold text-center mb-4">
                        Đổi mật khẩu
                    </h4>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.change-password.update') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Mật khẩu hiện tại
                            </label>

                            <input
                                type="password"
                                name="current_password"
                                class="form-control"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Mật khẩu mới
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                required
                            >
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                Xác nhận mật khẩu mới
                            </label>

                            <input
                                type="password"
                                name="password_confirmation"
                                class="form-control"
                                required
                            >
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Đổi mật khẩu
                        </button>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection