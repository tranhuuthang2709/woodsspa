<div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <div class="logo-header" data-background-color="dark">
            <a href="index.html" class="logo">
              <img
                src="{{ asset('assets') }}/admin//img/kaiadmin/logo_light.svg"
                alt="navbar brand"
                class="navbar-brand"
                height="50"
              />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Danh sách</h4>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.home')}}">
                  <i class="fas fa-layer-group"></i>
                  <p>Trang chủ</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.booking.list')}}">
                  <i class="fas fa-address-book"></i>
                  <p>Đơn đặt</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.categories.index')}}">
                  <i class="fas fa-th-list"></i>
                  <p>Danh mục</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.services.index')}}">
                  <i class="fas fa-print"></i>
                  <p>Dịch vụ</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.banner')}}">
                  <i class="fas fa-pen-square"></i>
                  <p>Quản lý banner</p>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>