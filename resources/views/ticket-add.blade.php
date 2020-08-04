@extends('master')
@section('head')
<title>DELI | Biên nhận thiết kế</title>
<link rel="stylesheet" href="{{secure_asset('plugins/select2/select2.min.css')}}">
@stop
@section('main')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>BIÊN NHẬN THIẾT KẾ</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item active">biên nhận</li>
          </ol>
        </div>
      </div>
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <section class="content">
    <!-- general form elements -->
    <div class="col-md-12">
      @if(count($client->tickets)>0)
      <div class="card card-info collapsed-card card-outline">
              <div class="card-header">
                <h3 class="card-title">Thông tin biên nhận gần đây! </h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
        <div class="card-body">
          <table class="table table-bordered">
            <tr class="text-center">
              <th>ID</th>
              <th>LĨNH VỰC KINH DOANH</th>
              <th>TÊN THƯƠNG HIỆU</th>
              <th>MÀU SẮC</th>
              <th>HÀNH ĐỘNG</th>
            </tr>
            @foreach($client->tickets as $data)
            <tr>
              <td class="text-center">{{$data->id}}</td>
              <td>{{$data->requestment}}</td>
              <td>{{$data->model}}</td>
              <td>{{$data->cpu}}</td>
              <td><a href="{{route('staff.ticket.useold.get', ['ticket_id' => $data->id])}}" class="btn btn-block btn-primary">Sử dụng</a></td>
            </tr>
            @endforeach
          </table>
        </div>
              <!-- /.card-body -->
            </div>
      @endif
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">NHẬP THÔNG TIN BIÊN NHẬN</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form role="form" action="{{route('staff.ticket.add.post')}}" method="post">
          {{csrf_field()}}
          <div class="card-body">
            <div class="form-group">
              <label for="inputSostt">Tên Khách hàng:</label> {{$client->name}} |
              <label for="inputSostt">Số Điện Thoại:</label> {{$client->phone}} |
              <label for="inputSostt">Ngày Sinh:</label> {{date("d/m/Y", strtotime($client->birthday))}}
              <input name="client_id" type="hidden" class="form-control" value="{{$client->id}}">
              <input name="staff_id" type="hidden" class="form-control" value="{{UserInfo()->id}}">
            </div>
            <div class="form-group">
              <label>Dịch vụ:</label>
              <select name="services[]" class="form-control select2" multiple="multiple" data-placeholder="Thiết kế Logo?" autofocus>
              @foreach($services as $service)
                <option value="{{$service->id}}">{{$service->name}}</option>
              @endforeach
              </select>
            </div>
            <!-- /.form-group -->
            <div class="form-group">
              <label for="requestment">Lĩnh vực kinh doanh:</label>
              <input name="requestment" type="text" class="form-control" id="requestment" placeholder="Thời trang, sự kiện, cá nhân, kinh doanh, nhà hàng, du lịch, ...">
            </div>
            <div class="form-group">
              <label for="model">Tên thương hiệu:</label>
              <input name="model" type="text" class="form-control" id="model" placeholder="DELI for anyone" @if(isset($ticket_old)) value="{{$ticket_old->model}}" @endif required>
            </div>
            <div class="form-group">
              <label for="cpu">Màu sắc:</label>
              <input name="cpu" type="text" class="form-control" id="cpu" placeholder="" @if(isset($ticket_old)) value="{{$ticket_old->cpu}}" @endif required>
            </div>
            <div class="form-group">
              <label for="ram">Mô tả yêu cầu:</label>
              <input name="ram" type="text" class="form-control" id="ram" placeholder="Mô tả yêu cầu" @if(isset($ticket_old)) value="{{$ticket_old->ram}}" @endif required>
            </div>
            <div class="form-group">
              <label for="storage">Phong cách thiết kế:</label>
              <input name="storage" type="text" class="form-control" id="storage" placeholder="Thời gian trả File 3 ngày trừ lễ và chủ nhật" @if(isset($ticket_old)) value="{{$ticket_old->storage}}" @endif required>
            </div>
            <div>
            </div>
            <div class="form-group">
              <label for="note">Bố cục thiết kế mà bạn mong muốn? (Ngang/Dọc):</label>
              <input name="note" type="text" class="form-control" id="note" placeholder="Bố cục thiết kế mà bạn mong muốn? (Ngang/Dọc)" required>
            </div>
            <div class="form-group">
              <label for="other">IN ẤN:</label>
              <input name="other" type="text" class="form-control" id="other" placeholder="Vị trí đặt Logo mà bạn mong muốn?(Trái, phải, trên, dưới hoặc ở giữa namecard)" required>
            </div>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <button type="submit" class="btn btn-primary">Thêm vào</button>
            <a onclick="history.go(-1);" class="btn">Quay lại</a>
          </div>
        </form>
      </div>
      <!-- /.card -->
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@stop

@section('script')
<!-- Select2 -->
<script src="{{secure_asset('plugins/select2/select2.full.min.js')}}"></script>

<script>
  $(function () {
    $('.select2').select2()
  });
</script>
@stop