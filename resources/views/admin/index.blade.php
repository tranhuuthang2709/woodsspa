<!DOCTYPE html>
<html lang="en">
  <head>
    @include('admin.layouts.head')
  </head>
  <body>
    <div class="wrapper">
      @include('admin.layouts.sidebar')

      <div class="main-panel">
        @include('admin.layouts.nav')

        <div class="container">
          @yield('content')
        </div>

      </div>
    </div>
    @include('admin.layouts.js')
        @stack('scripts')
  </body>
</html>
