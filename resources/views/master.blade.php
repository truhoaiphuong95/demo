<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  @yield('head')
  <title>DELI | Blank Page</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{secure_asset('dist/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{secure_asset('dist/css/custom.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="sidebar-mini control-sidebar-slide-open sidebar-collapse">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand border-bottom navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('staff.dashboard.view.get')}}" class="nav-link">Trang chủ</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="https://www.facebook.com/" class="nav-link">Facebook</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="https://drive.google.com/drive/u/0/my-drive" class="nav-link">Drive</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form action="{{route('staff.search.get')}}" method="get" class="form-inline ml-3" >
      <div class="input-group input-group-md">
        <input name="keyword" class="form-control form-control-navbar" type="search" placeholder="Số điện thoại / Biên nhận" aria-label="Tìm số điện thoại">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
    </form>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <img src="{{secure_asset('dist/img/AdminLTELogo.png')}}"
           alt="AdminLTE Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">DELI System</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{secure_asset('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{route('staff.profile.edit.get')}}" class="d-block">{{ UserInfo()->name }}</a>
        </div>
        <div class="info">
          <a href="{{route('staff.logout.get')}}" class="d-block"><i class="fa fa-sign-out"></i></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          </li>
          @if(UserInfo()->isManager())
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link ">
              <i class="nav-icon fa fa-briefcase"></i>
              <p>
                PHÒNG QUẢN LÝ
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('staff.shift.manager.get')}}" class="nav-link">
                  <i class="fa fa-calendar-check-o nav-icon"></i>
                  <p>Sắp lịch làm</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('staff.client.list.get')}}" class="nav-link">
                  <i class="nav-icon fa fa-users"></i>
                  <p>Danh sách khách hàng</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('staff.statistic.finance.get')}}" class="nav-link">
                  <i class="fa fa-bar-chart nav-icon"></i>
                  <p>Thống kê doanh số</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link ">
              <i class="nav-icon fa fa-file-text"></i>
              <p>
                PHÒNG HÀNH CHÍNH
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('staff.worklog.add.get')}}" class="nav-link">
                  <i class="fa fa-plus nav-icon"></i>
                  <p>Nộp báo cáo</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('staff.worklog.list.get')}}" class="nav-link">
                  <i class="fa fa-history nav-icon"></i>
                  <p>Xem báo cáo</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('staff.shift.view.get')}}" class="nav-link">
                  <i class="fa fa-calendar nav-icon"></i>
                  <p>Xem lịch làm</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('staff.shift.register.get')}}" class="nav-link">
                  <i class="fa fa-calendar-plus-o nav-icon"></i>
                  <p>Đăng ký lịch làm</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link ">
              <i class="nav-icon fa fa-wrench"></i>
              <p>
                PHÒNG THIẾT KẾ
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('staff.ticket.list.get')}}" class="nav-link">
                  <i class="fa fa-list nav-icon"></i>
                  <p>Biên nhận thiết kế</p>
                </a>
              </li>
              @if(UserInfo()->isManager())
              <li class="nav-item">
                <a href="{{route('staff.ticketlog.list.get')}}" class="nav-link">
                  <i class="fa fa-history nav-icon"></i>
                  <p>Nhật ký thay đổi</p>
                </a>
              </li>
              @endif
              <li class="nav-item">
                <a href="{{route('staff.feedback.list.get')}}" class="nav-link">
                  <i class="fa fa-heartbeat nav-icon"></i>
                  <p>CSKH</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link ">
              <i class="nav-icon fa fa-cube"></i>
              <p>
                DỊCH VỤ - BÁO GIÁ
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('staff.service.list.get')}}" class="nav-link">
                  <i class="fa fa-list nav-icon"></i>
                  <p>Dịch vụ thiết kế</p>
                </a>
              </li>
              @if(UserInfo()->isManager())
              <li class="nav-item">
                <a href="{{route('staff.service.add.get')}}" class="nav-link">
                  <i class="fa fa-history nav-icon"></i>
                  <p>Thêm dịch vụ</p>
                </a>
              </li>
              @endif
            </ul>
          </li>

          <!-- Dự án -->
          @if(UserInfo()->isManager())
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link ">
              <i class="nav-icon fa fa-university"></i>
              <p>
                DỰ ÁN THIẾT KẾ
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('staff.course.list.get')}}" class="nav-link">
                  <i class="fa fa-list nav-icon"></i>
                  <p>Danh sách dự án</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('staff.course.add.get')}}" class="nav-link">
                  <i class="fa fa-plus nav-icon"></i>
                  <p>Thêm dự án</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
          <!-- Dự án -->
          
          @if(UserInfo()->isManager())
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link ">
              <i class="nav-icon fa fa-money"></i>
              <p>
                PHÒNG KẾ TOÁN
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('staff.receipt.list.get')}}" class="nav-link">
                  <i class="fa fa-arrow-left nav-icon"></i>
                  <p>Phiếu thu</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('staff.payment.list.get')}}" class="nav-link">
                  <i class="fa fa-arrow-right nav-icon"></i>
                  <p>Phiếu chi</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
            </ul>
          </li>
          @endif
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link ">
              <i class="nav-icon fa fa-link"></i>
              <p>
                THƯ VIỆN VÀ TÀI LIỆU
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('staff.download.list.get')}}" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Danh sách</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('staff.download.add.get')}}" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Thêm mới</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-header">Tài khoản</li>
          <li class="nav-item">
            <a href="{{route('staff.logout.get')}}" class="nav-link">
              <i class="nav-icon fa fa-sign-out"></i>
              <p>Đăng xuất</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

@yield('main')

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.0-alpha
    </div>
    <strong>Copyright &copy; 2019-2020 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
    reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{secure_asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{secure_asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- SlimScroll -->
<script src="{{secure_asset('plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{secure_asset('plugins/fastclick/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{secure_asset('dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{secure_asset('dist/js/demo.js')}}"></script>
@yield('script')
</body>
</html>
