@extends('master')
@section('head')
<title>KING | Thống kê tài chính</title>
<link rel="stylesheet" href="{{secure_asset('plugins/datatables/dataTables.bootstrap4.css')}}">
<style>
  .pagination li {
    padding: 10px;
  }
  .pagination {
    float: right;
  }
</style>
@stop
@section('main')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Thống kê kỹ thuật</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item active">Thống kê</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header no-border">
            <div class="d-flex justify-content-between">
              <h3 class="card-title">Số lượng máy nhận năm 2020</h3>
            </div>
          </div>
          <div class="card-body">
            <div class="d-flex">
              <p class="d-flex flex-column">
                <span class="text-bold text-lg">{{ $ticket_sum }}</span>
                <span>Lượt trong năm nay</span>
              </p>
              <p class="ml-auto d-flex flex-column text-right">
                @if ($ticket_growth>0)
                <span class="text-success">
                  <i class="fa fa-arrow-up"></i> {{ $ticket_growth }}%
                </span>
                @else
                <span class="text-danger">
                  <i class="fa fa-arrow-down"></i> {{ $ticket_growth }}%
                </span>
                @endif
                <span class="text-muted">So với tháng trước</span>
              </p>
            </div>
            <!-- /.d-flex -->

            <div class="position-relative mb-4">
              <canvas id="tickets-chart"></canvas>
            </div>

            <div class="d-flex flex-row justify-content-end">
              <span class="mr-2">
                <i class="fa fa-square text-primary"></i> Số lượng biên nhận kỹ thuật
              </span>
            </div>
          </div>
        </div>
        <!-- /.card -->
      </div>
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header no-border">
            <div class="d-flex justify-content-between">
              <h3 class="card-title">Số lượng học viên đăng ký năm 2020</h3>
            </div>
          </div>
          <div class="card-body">
            <div class="d-flex">
              <p class="d-flex flex-column">
                <span class="text-bold text-lg">{{ $student_sum }}</span>
                <span>Lượt trong năm nay</span>
              </p>
              <p class="ml-auto d-flex flex-column text-right">
                @if ($student_growth>0)
                <span class="text-success">
                  <i class="fa fa-arrow-up"></i> {{ $student_growth }}%
                </span>
                @else
                <span class="text-danger">
                  <i class="fa fa-arrow-down"></i> {{ $student_growth }}%
                </span>
                @endif
                <span class="text-muted">So với tháng trước</span>
              </p>
            </div>
            <!-- /.d-flex -->

            <div class="position-relative mb-4">
              <canvas id="students-chart"></canvas>
            </div>

            <div class="d-flex flex-row justify-content-end">
              <span class="mr-2">
                <i class="fa fa-square text-primary"></i> Số lượng biên nhận kỹ thuật
              </span>
            </div>
          </div>
        </div>
        <!-- /.card -->
      </div>

      @foreach($fields as $f => $field)
      <div class="col-lg-7">
        <div class="card">
          <div class="card-header no-border">
            <div class="d-flex justify-content-between">
              <h3 class="card-title">Tài chính {{$field->name}} năm 2020</h3>
            </div>
          </div>
          <div class="card-body">
            <div class="d-flex">
              <p class="d-flex flex-column">
                <span class="text-bold text-lg"><span class="text-success">{{ MoneyFormat($receipt_sum[$f]) }}</span><span class="text-danger"> - {{ MoneyFormat($payment_sum[$f]) }}</span> = {{ MoneyFormat($receipt_sum[$f]-$payment_sum[$f]) }}</span>
                <span>Doanh thu - Chi phí = Lợi nhuận</span>
              </p>
              <p class="ml-auto d-flex flex-column text-right">
                @if ($receipt_growth[$f]>0)
                <span class="text-success">
                  <i class="fa fa-arrow-up"></i> {{ $receipt_growth[$f] }}%
                </span>
                @else
                <span class="text-danger">
                  <i class="fa fa-arrow-down"></i> {{ $receipt_growth[$f] }}%
                </span>
                @endif
                <span class="text-muted">So với tháng trước</span>
              </p>
            </div>
            <!-- /.d-flex -->

            <div class="position-relative mb-4">
              <canvas id="{{$field->key}}-fin-chart"></canvas>
            </div>

            <div class="d-flex flex-row justify-content-end">
              <span class="mr-2">
                <i class="fa fa-square text-success"></i> Thu
                <i class="fa fa-square text-danger"></i> Chi
                <i class="fa fa-square text-primary"></i> Lợi nhuận
              </span>
            </div>
          </div>
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col-md-12 -->
      <div class="col-lg-5">
        <div class="card card-primary">
          <div class="card-body">
            <table class="table table-bordered">
              <tbody>
                <tr>
                  <th></th>
                  <th>Thu</th>
                  <th>Chi</th>
                  <th>Lợi nhuận</th>
                </tr>
                @for($i=0; $i<6; $i++)
                <tr>
                  <td>Tháng {{$i+1}}</td> 
                  <td>{{MoneyFormat($receipt_count[$f][$i])}}</td>
                  <td>{{MoneyFormat($payment_count[$f][$i])}}</td>
                  <td>{{MoneyFormat($receipt_count[$f][$i]-$payment_count[$f][$i])}}</td>
                </tr>
                @endfor
              </tbody>
            </table>
          </div>
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col-md-12 -->
      @endforeach
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@stop

@section('script')
<script src="{{secure_asset('plugins/chart.js/Chart.min.js')}}"></script>
<script>
  $(function() {
    'use strict'
    var ticksStyle = {
      fontColor: '#495057',
      fontStyle: 'bold'
    }
    var mode = 'index'
    var intersect = true
    var $ticketsChart = $('#tickets-chart')
    var ticketsChart = new Chart($ticketsChart, {
      data: {
        labels: [
          'Tháng 1',
          'Tháng 2',
          'Tháng 3',
          'Tháng 4',
          'Tháng 5',
          'Tháng 6',
          'Tháng 7',
          'Tháng 8',
          'Tháng 9',
          'Tháng 10',
          'Tháng 11',
          'Tháng 12'
        ],
        datasets: [{
          type: 'line',
          data: [
            @foreach($ticket_count as $data)
              {{ $data }},
            @endforeach
          ],
          backgroundColor: 'transparent',
          borderColor: '#007bff',
          pointBorderColor: '#007bff',
          pointBackgroundColor: '#007bff',
          fill: false
          // pointHoverBackgroundColor: '#007bff',
          // pointHoverBorderColor    : '#007bff'
        }]
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          mode: mode,
          intersect: intersect
        },
        hover: {
          mode: mode,
          intersect: intersect
        },
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            // display: false,
            gridLines: {
              display: true,
              lineWidth: '4px',
              color: 'rgba(0, 0, 0, .2)',
              zeroLineColor: 'transparent'
            },
            ticks: $.extend({
              beginAtZero: true,
              suggestedMax: 100
            }, ticksStyle)
          }],
          xAxes: [{
            display: true,
            gridLines: {
              display: false
            },
            ticks: ticksStyle
          }]
        }
      }
    })
    var $studentsChart = $('#students-chart')
    var studentsChart = new Chart($studentsChart, {
      data: {
        labels: [
          'Tháng 1',
          'Tháng 2',
          'Tháng 3',
          'Tháng 4',
          'Tháng 5',
          'Tháng 6',
          'Tháng 7',
          'Tháng 8',
          'Tháng 9',
          'Tháng 10',
          'Tháng 11',
          'Tháng 12'
        ],
        datasets: [{
          type: 'line',
          data: [
            @foreach($student_count as $data) 
              {{ $data }},
            @endforeach
          ],
          backgroundColor: 'transparent',
          borderColor: '#007bff',
          pointBorderColor: '#007bff',
          pointBackgroundColor: '#007bff',
          fill: false
          // pointHoverBackgroundColor: '#007bff',
          // pointHoverBorderColor    : '#007bff'
        }]
      },
      options: {
        maintainAspectRatio: false,
        tooltips: {
          mode: mode,
          intersect: intersect
        },
        hover: {
          mode: mode,
          intersect: intersect
        },
        legend: {
          display: false
        },
        scales: {
          yAxes: [{
            // display: false,
            gridLines: {
              display: true,
              lineWidth: '4px',
              color: 'rgba(0, 0, 0, .2)',
              zeroLineColor: 'transparent'
            },
            ticks: $.extend({
              beginAtZero: true,
              suggestedMax: 100
            }, ticksStyle)
          }],
          xAxes: [{
            display: true,
            gridLines: {
              display: false
            },
            ticks: ticksStyle
          }]
        }
      }
    })
    @foreach($fields as $f => $field)
    var ${{$field->key}}Chart = $('#{{$field->key}}-fin-chart')
    var {{$field->key}}Chart = new Chart(${{$field->key}}Chart, {
        data: {
          labels: [
            'Tháng 1',
            'Tháng 2',
            'Tháng 3',
            'Tháng 4',
            'Tháng 5',
            'Tháng 6',
            'Tháng 7',
            'Tháng 8',
            'Tháng 9',
            'Tháng 10',
            'Tháng 11',
            'Tháng 12'
          ],
          datasets: [{
              type: 'line',
              data: [
                @foreach($receipt_count[$f] as $data) 
                {{$data}},
                @endforeach
              ],
              backgroundColor: 'transparent',
              borderColor: '#28a745',
              pointBorderColor: '#28a745',
              pointBackgroundColor: '#28a745',
              fill: false
              // pointHoverBackgroundColor: '#007bff',
              // pointHoverBorderColor    : '#007bff'
            },
            {
              type: 'line',
              data: [
                @foreach($payment_count[$f] as $data) 
                {{$data}},
                @endforeach
              ],
              backgroundColor: 'tansparent',
              borderColor: '#dc3545',
              pointBorderColor: '#dc3545',
              pointBackgroundColor: '#dc3545',
              fill: false
              // pointHoverBackgroundColor: '#ced4da',
              // pointHoverBorderColor    : '#ced4da'
            },
            {
              type: 'line',
              data: [
                @foreach($receipt_count[$f] as $i => $data) 
                {{$data - $payment_count[$f][$i]}},
                @endforeach
              ],
              backgroundColor: 'tansparent',
              borderColor: '#007bff',
              pointBorderColor: '#007bff',
              pointBackgroundColor: '#007bff',
              fill: false
              // pointHoverBackgroundColor: '#ced4da',
              // pointHoverBorderColor    : '#ced4da'
            }
          ]
        },
        options: {
          maintainAspectRatio: false,
          tooltips: {
            mode: mode,
            intersect: intersect
          },
          hover: {
            mode: mode,
            intersect: intersect
          },
          legend: {
            display: false
          },
          scales: {
            yAxes: [{
              // display: false,
              gridLines: {
                display: true,
                lineWidth: '4px',
                color: 'rgba(0, 0, 0, .2)',
                zeroLineColor: 'transparent'
              },
              ticks: $.extend({
                beginAtZero: true,
                suggestedMax: 100,
                callback(value) {
                  return Number(value).toLocaleString('en')
                }
              }, ticksStyle)
            }],
            xAxes: [{
              display: true,
              gridLines: {
                display: false
              },
              ticks: ticksStyle
            }]
          },
        }
      })
    @endforeach
  });
</script>
@stop 