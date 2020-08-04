@extends('master')
@section('head')
<title>DELI | Khách hàng: {{$client->name}}</title>
<link rel="stylesheet" href="{{secure_asset('plugins/datatables/dataTables.bootstrap4.css')}}">
@stop
@section('main')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="text-uppercase">KHÁCH HÀNG: <b class="text-prmary">{{$client->name}}</b></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item active">Thông tin khách hàng</li>
          </ol>
        </div>
      </div>
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      @if (session('success'))
      <div class="row">
        <div class="col-md-12">
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fa fa-check"></i> Thành công!</h5>
            {{ session('success') }}
          </div>
        </div>
      </div>
      @endif
      @if (session('error'))
      <div class="row"><div class="col-md-12">
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h5><i class="icon fa fa-ban"></i> Thất bại!</h5> 
          {{ session('error') }}
        </div>
      </div></div>
      @endif
      <div class="row">
        <!-- /.col -->
        <div class="col-md-3">
          <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle" src="{{secure_asset('dist/img/user4-128x128.jpg')}}" alt="User profile picture">
              </div>
              <h3 class="profile-username text-center text-uppercase">{{$client->name}}</h3>
              <!--<p class="text-muted text-center">Software Engineer</p>-->
              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b>SỐ ĐIỆN THOẠI:</b> <a class="float-right" href="tel:{{$client->sdt}}"> {{$client->phone}}</a>
                </li>
                <li class="list-group-item">
                  <b>NGÀY SINH:</b> <a class="float-right">@if (isset($client->birthday)) {{date("d/m/Y", strtotime($client->birthday))}} @else Không có @endif</a>
                </li>
                <li class="list-group-item">
                  <b>ZALO:</b> @if ($client->zalo!="") <a class="float-right" href="https://zalo.me/{{$client->zalo}}">{{$client->zalo}}</a>  @else <a class="float-right">Không có</a> @endif
                </li>
                <li class="list-group-item">
                  <b>EMAIL:</b> @if ($client->email!="") <a class="float-right">{{$client->email}}</a> @else <a class="float-right">Không có</a> @endif
                </li>
                <li class="list-group-item text-uppercase">
                  <b>NGÀNH NGHỀ KINH DOANH:</b> @if ($client->major!="") <a class="float-right">{{$client->major}}</a> @else <a class="float-right">Không có</a> @endif
                </li>
              </ul>
              @if(UserInfo()->isManager())
              <a href="{{route('staff.payment.add.get', ['client_id'=>$client->id])}}" class="btn btn-block btn-default" id="btnThemphieuchi">
              <i class="fa fa-arrow-right"></i> Thêm phiếu chi (F6)
              </a>
              <a href="{{route('staff.receipt.add.get', ['client_id'=>$client->id])}}" class="btn btn-block btn-default" id="btnThemphieuthu">
              <i class="fa fa-arrow-left"></i> Thêm phiếu thu (F7)
              </a>
              <a href="{{route('staff.coursestudent.add.get', ['client_id'=>$client->id])}}" class="btn btn-block btn-default" id="btnThemvaolop">
              <i class="fa fa-university"></i> THÊM VÀO DỰ ÁN (F9)
              </a>
              <a href="{{route('staff.client.edit.get', ['client_id'=>$client->id])}}" class="btn btn-info btn-block"><b>Sửa thông tin</b></a>
              @endif
              <a href="{{route('staff.ticket.add.get', ['client_id'=>$client->id])}}" class="btn btn-block btn-default" id="btnThembiennhan">
                <i class="fa fa-book"></i> BIÊN NHẬN THIẾT KẾ
              </a>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-9">
          <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">DANH SÁCH BIÊN NHẬN THIẾT KẾ</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr class="text-center">
                    <th>NGÀY NHẬN</th>
                    <th>SỐ PHIẾU</th>
                    <th>TÊN THƯƠNG HIỆU</th>
                    <th>LĨNH VỰC KINH DOANH</th>
                    <th>TIẾN ĐỘ THIẾT KẾ</th>
                    <th>HÀNH ĐỘNG</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($client->tickets as $data)
                  <tr>
                    <td class="text-center">{{date("d/m/Y", strtotime($data->created_at))}}</td>
                    <td class="text-center">{{$data->id}}</td>
                    <td>{{$data->model}}</td>
                    <td>{{$data->requestment}}</td>
                    <td class="text-center">
                      <span class="badge bg-{{$data->ticketStatus->class}}">{{$data->ticketStatus->name}}</span>
                    </td>
                    <td class="text-center"><a href="{{route('staff.ticket.view.get', ['ticket_id' => $data->id])}}" class="btn btn-primary">Xem</a></td>
                  </tr>
                  @endforeach
                  </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

          <!-- DANH SÁCH DỰ ÁN -->
          @if(UserInfo()->isManager())
          <div class="card card card-info">
            <div class="card-header">
              <h3 class="card-title">DANH SÁCH DỰ ÁN THIẾT KẾ</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-striped">
                <thead>
                  <tr class="text-center">
                    <th>STT</th>
                    <th>TÊN THƯƠNG HIỆU</th>
                    <th>ƯU ĐÃI</th>
                    <th>BÁO GIÁ</th>
                    <th>ĐÃ THU</th>
                    <th>CHƯA THU</th>
                    <th>HÀNH ĐỘNG</th>
                  </tr>
                </thead>
                @php $i=1 @endphp
                <tbody>
                  @foreach($client->courseStudents as $data)
                  <tr>
                    <td class="text-center">{{ $i++ }}</td>
                    <td>{!!$data->course->linkName()!!}</td>
                    <td class="text-center">{{$data->deal_rate}}%</td>
                    <td class="text-right">{{MoneyFormat($data->course->tuition * (1-$data->deal_rate/100))}}</td>
                    <td class="text-right">{{MoneyFormat($data->tuition_done)}}</td>
                    <td class="text-right">{{MoneyFormat($data->course->tuition * (1-$data->deal_rate/100) - $data->tuition_done)}}</td>
                    <td class="text-center"><a href="{{route('staff.coursestudent.edit.get', ['coursestudent_id' => $data->id])}}" class="btn btn-primary">Sửa</a></td>
                  </tr>
                  @endforeach
                  </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          @endif
          <!-- DANH SÁCH DỰ ÁN -->
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@stop
@section('script')
<script src="{{secure_asset('plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{secure_asset('plugins/datatables/dataTables.bootstrap4.js')}}"></script>
<script>
  $(function () {
    $("#example1").DataTable({
        "order": [[ 1, "desc" ]],
        "language": {
          "sProcessing":   "Đang xử lý...",
          "sLengthMenu":   "Xem _MENU_ mục",
          "sZeroRecords":  "Không tìm thấy dòng nào phù hợp",
          "sInfo":         "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục",
          "sInfoEmpty":    "Đang xem 0 đến 0 trong tổng số 0 mục",
          "sInfoFiltered": "(được lọc từ _MAX_ mục)",
          "sInfoPostFix":  "",
          "sSearch":       "Tìm:",
          "sUrl":          "",
          "oPaginate": {
            "sFirst":    "Đầu",
            "sPrevious": "Trước",
            "sNext":     "Tiếp",
            "sLast":     "Cuối"
          }
        }
    });
    $("#example2").DataTable({
        "order": [[ 1, "desc" ]],
        "language": {
          "sProcessing":   "Đang xử lý...",
          "sLengthMenu":   "Xem _MENU_ mục",
          "sZeroRecords":  "Không tìm thấy dòng nào phù hợp",
          "sInfo":         "Đang xem _START_ đến _END_ trong tổng số _TOTAL_ mục",
          "sInfoEmpty":    "Đang xem 0 đến 0 trong tổng số 0 mục",
          "sInfoFiltered": "(được lọc từ _MAX_ mục)",
          "sInfoPostFix":  "",
          "sSearch":       "Tìm:",
          "sUrl":          "",
          "oPaginate": {
            "sFirst":    "Đầu",
            "sPrevious": "Trước",
            "sNext":     "Tiếp",
            "sLast":     "Cuối"
          }
        }
    });
  });
  window.onkeydown = function(evt) {
    if (evt.keyCode == 117) //F6
        document.getElementById("btnThemphieuchi").click();
    if (evt.keyCode == 118) //F7
        document.getElementById("btnThemphieuthu").click();
    if (evt.keyCode == 119) //F8
        document.getElementById("btnThembiennhan").click();
    if (evt.keyCode == 120) //F9
        document.getElementById("btnThemvaolop").click();
  };
</script>
@stop