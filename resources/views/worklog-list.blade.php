@extends('master')
@section('head')
<title>DELI | Báo cáo</title>
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
            <h1 class="text-primary">BÁO CÁO CÔNG VIỆC</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('staff.dashboard.view.get')}}">Trang chủ</a></li>
              <li class="breadcrumb-item active">Báo cáo</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        @if (session('success'))
        <div class="row"><div class="col-md-12">
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fa fa-check"></i> Thành công!</h5> {{ session('success') }}
          </div>
        @endif
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">DANH SÁCH BÁO CÁO CÔNG VIỆC HÀNG NGÀY</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr class="text-center">
                        <th style="width: 200px;">NGÀY</th>
                        <th style="width: 200px;">BUỔI</th>
                        <th style="width: 200px;">NGƯỜI BÁO CÁO</th>
                        <th>NỘI DUNG</th>
                        <th>HÀNH ĐỘNG</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($worklogs as $worklog)
                      <tr>
                        <td class="text-center">{{date('d/m/Y',strtotime($worklog->date))}}</td>
                        <td class="text-center">{{$session[$worklog->session]}}</td>
                        <td class="text-uppercase"><b>{{$worklog->staff->name}}</b></td>
                        <td>@if(UserInfo()->isManager()) {!!$worklog->content!!} @elseif ($worklog->staff->id == UserInfo()->id) {!!$worklog->content!!} @endif</td>
                        <td>@if($worklog->staff->id == UserInfo()->id) <a href="{{route('staff.worklog.edit.get', ['worklog_id' => $worklog->id])}}" style="float: right;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> @endif</td>
                      </tr>
                      @endforeach
                    </tbody>
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
  $(function () {
    $("#example1").DataTable({
        "ordering": false,
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

</script>
@stop