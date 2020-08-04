@extends('master')

@section('head')
<title>DELI | Báo cáo</title>
<link rel="stylesheet" href="{{ secure_asset('plugins/select2/select2.min.css') }}">
@stop

@section('main')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>BÁO CÁO CÔNG VIỆC</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item active">Báo cáo</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      @if (count($errors) > 0)
      @foreach ($errors->all() as $error)
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i> Thất bại!</h4> {!! $error !!}
      </div>
      @endforeach
      @endif
      <form action="{{route('staff.worklog.add.post')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="staff_id" value="{{UserInfo()->id}}" />
        <div class="row">
          <div class="col">
            Nội quy và trình tự báo cáo
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="card card-primary">
              <div class="card-body">
                <div class="col-md-12">
                  <div class="form-group col-md-12" >
                    <label>Ngày làm việc:</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                      </div>
                      <input type="date" name="date" class="form-control" value="{{$today}}" required>
                    </div>
                    <!-- /.input group -->
                  </div>
                  <div class="form-group col-md-12">
                    <label>Chọn buổi làm việc:</label>
                    <select name="session" class="form-control select2" style="width: 100%;" required>
                      <option disabled selected value> -- Chọn buổi làm việc -- </option>
                      <option value="morning">Buổi sáng</option>
                      <option value="afternoon">Buổi chiều</option>
                      <option value="everning">Buổi tối</option>
                    </select>
                  </div>
                  <div class="col-md-12">
                    <label>Viết mô tả nội dung và tiến độ công việc:</label>
                    <textarea id="editor1" name="content" style="width: 100%" placeholder="Nội dung công việc chi tiết"></textarea>
                  </div>
                  <!-- /.col-->
                  <!-- <div class="form-group col-md-12">
                    <label>Nội dung công việc</label>
                    <textarea name="content" class="form-control" rows="3" placeholder="Mỗi công việc nhập một dòng, chi tiết và cụ thể"></textarea>
                  </div> -->
                </div>
              </div>
              <div class="card-footer">
                <button type="submit" class="btn btn-primary pull-right">Gửi báo cáo</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@stop
@section('script')
<!-- bootstrap datepicker -->
<script language="JavaScript" type="text/javascript" src="{{ asset('/plugins/jquery/jquery.min.js')}}"></script>
<script language="JavaScript" type="text/javascript" src="{{ asset('/plugins/select2/select2.full.min.js')}}"></script>
<script language="JavaScript" type="text/javascript" src="{{ asset('/plugins/ckeditor/ckeditor.js')}}"></script>
<script>
  /* global $ */
  $(function() {
    $('.select2').select2()
    ClassicEditor
      .create(document.querySelector('#editor1'))
      .then(function(editor) {
        // The editor instance
      })
      .catch(function(error) {
        console.error(error)
      })
  })
</script>
@stop