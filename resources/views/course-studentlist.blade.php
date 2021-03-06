@extends('master')
@section('head')
<title>DELI | Danh sách dự án</title>
<link rel="stylesheet" href="{{secure_asset('plugins/datatables/dataTables.bootstrap4.css')}}">
@stop
@section('main')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      @if (session('success'))
      <div class="row">
        <div class="col-md-12">
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fa fa-check"></i> Thành công!</h5> {{ session('success') }}
          </div>
        </div>
      </div>
      @endif
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>THÔNG TIN KHÁCH HÀNG ĐẶT THIẾT KẾ</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item active">Thông tin khách hàng đặt thiết kế</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-6">
        <div class="card card-widget widget-user-2">
          <!-- Add the bg color to the header using any of the bg-* classes -->
          <div class="widget-user-header bg-primary">
            <div class="widget-user-image">
              <img class="img-circle elevation-2" src="{{secure_asset('images/course-avt.png')}}" alt="User Avatar">
            </div>
            <!-- /.widget-user-image -->
            <h3 class="widget-user-username">TÊN KHÁCH HÀNG: <b class="text-uppercase">{{$course->name}}</b></h3>
            <h5 class="widget-user-desc">DEADLINE: <b>{{$course->schedule}}</b></h5>
          </div>
          <div class="card-body p-0">
            <ul class="nav flex-column">
              <li class="nav-item">
                <div class="nav-link">
                  NGÀY NHẬN: <span class="float-right">@if($course->opening_at==NULL) Chưa có @else {{$course->opening_at}} @endif</span>
                </div>
              </li>
              <li class="nav-item">
                <div class="nav-link">
                  BÁO GIÁ: <span class="float-right">{{ MoneyFormat($course->tuition) }}</span>
                </div>
              </li>
              <li class="nav-item">
                <div class="nav-link">
                  THỜI GIAN THIẾT KẾ: <span class="float-right">{{$course->lesson}} ngày</span>
                </div>
              </li>
              <li class="nav-item">
                <div class="nav-link">
                  NHÀ THIẾT KẾ: <span class="float-right"><b class="text-uppercase">{{$course->teacher}}</b></span>
                </div>
              </li>
            </ul>
          </div>
          <div class="card-footer">
            <a class="btn btn-default"  href="{{ route('staff.course.exportphone.get', ['course_id' => $course->id]) }}">LẤY SỐ ĐIỆN THOẠI</a>
            <a class="btn btn-default"  href="{{ route('staff.course.exportexcel.get', ['course_id' => $course->id]) }}">TẢI EXCEL</a>
            <div class="btn-group float-right">
              <a href="{{ route('staff.course.edit.get', ['course_id' => $course->id]) }}" class="btn btn-primary">THAY ĐỔI THÔNG TIN</a>
              <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
              </button>
              <div class="dropdown-menu" role="menu">
                <a class="dropdown-item" href="{{ route('staff.course.delete.get', ['course_id' => $course->id]) }}">XÓA</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card card-info">
          <div class="card-body">
            <ul class="nav flex-column">
              <li class="nav-item">
                <div class="nav-link">
                  Đăng ký <span class="float-right">{{ $course->sum() }}</span>
                </div>
              </li>
              <li class="nav-item">
                <div class="nav-link">
                  Đã đóng giữ chỗ <span class="float-right">{{ $course->sumDeposited() }}</span>
                </div>
              </li>
              <li class="nav-item">
                <div class="nav-link">
                  Đã hoàn thành <span class="float-right">{{ $course->sumDone() }}</span>
                </div>
              </li>
              <li class="nav-item">
                <div class="nav-link">
                  Tối đa <span class="float-right">{{ $course->maxseat }}</span>
                </div>
              </li>
              <li class="nav-item">
                <div class="nav-link">
                  Dự kiến thu <span class="float-right">{{ MoneyFormat($course->revenue()) }}</span>
                </div>
              </li>
              <li class="nav-item">
                <div class="nav-link">
                  Đã thu <span class="float-right">{{ MoneyFormat($course->collected()) }}</span>
                </div>
              </li>
              <li class="nav-item">
                <div class="nav-link">
                  Chưa thu <span class="float-right">{{ MoneyFormat($course->revenue()-$course->collected()) }}</span>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">TÊN KHÁCH HÀNG: <b class="text-uppercase">{{$course->name}}</b></h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr class="text-center">
                  <th>STT</th>
                  <th>TÊN KHÁCH HÀNG</th>
                  <th>SỐ ĐIỆN THOẠI</th>
                  <th>ƯU ĐÃI</th>
                  <th>BÁO GIÁ</th>
                  <th>ĐÃ THU</th>
                  <th>CHƯA THU</th>
                  <th>GHI CHÚ</th>
                  <th>HÀNH ĐỘNG</th>
                </tr>
              </thead>
              <tbody>
              @php $i=1 @endphp 
                @foreach($students as $data)
                <tr>
                  <td class="text-center">{{ $i++ }}</td>
                  <td class="text-uppercase">{!! $data->client->linkName() !!}</td>
                  <td class="text-center">{!! $data->client->linkPhone() !!}</td>
                  <td class="text-center">{{ $data->deal_rate }}%</td>
                  <td class="text-right">{{ MoneyFormat(TuitionAfter($course->tuition, $data->deal_rate)) }}</td>
                  <td class="text-right">{{ MoneyFormat($data->tuition_done) }}</td>
                  <td class="text-right">
                  @if($data->tuition_done > 0)
                    @if( $data->tuition_done >= TuitionAfter($course->tuition, $data->deal_rate) ) 
                      <span class="badge bg-success">HOÀN THÀNH</span>
                    @else
                      <span class="badge bg-info">{{TuitionAfter($course->tuition, $data->deal_rate) - $data->tuition_done}}</span>
                    @endif
                  @else
                    {{ MoneyFormat(($course->tuition*(1-$data->deal_rate/100)) - $data->tuition_done) }}
                  @endif
                  </td>
                  <td>{{$data->deal_note}}</td>
                  <td class="text-center">
                    <div class="btn-group">
                      <a href="{{route('staff.coursestudent.edit.get', ['coursestudent_id' => $data->id])}}" class="btn btn-primary">Sửa</a>
                      <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <div class="dropdown-menu" role="menu">
                        <a class="dropdown-item" href="{{route('staff.coursestudent.delete.get', ['coursestudent_id' => $data->id])}}">Xóa</a>
                      </div>
                    </div>
                  </td>
                </tr>
                @endforeach
                </tfoot>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@stop

@section('script')
<script src="{{secure_asset('plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{secure_asset('plugins/datatables/dataTables.bootstrap4.js')}}"></script>
<script>
  $(function() {
    $("#example1").DataTable({
      "ordering": false,
      "pageLength": 50,
      "language": {
        "sProcessing": "Đang xử lý...",
        "sLengthMenu": "Xem _MENU_ mục",
        "sZeroRecords": "Không tìm thấy dòng nào phù hợp",
        "sInfo": "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục",
        "sInfoEmpty": "Đang xem 0 đến 0 trong tổng số 0 mục",
        "sInfoFiltered": "(được lọc từ _MAX_ mục)",
        "sInfoPostFix": "",
        "sSearch": "Tìm:",
        "sUrl": "",
        "oPaginate": {
          "sFirst": "Đầu",
          "sPrevious": "Trước",
          "sNext": "Tiếp",
          "sLast": "Cuối"
        }
      }
    });
  });
</script>
@stop