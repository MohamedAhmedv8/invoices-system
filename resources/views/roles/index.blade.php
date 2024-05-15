@extends('layouts.master')
@section('title')
    صلاحيات المستخدمين - برنامج ادارة الفواتير   
@stop
@section('css')
    <!--Internal   Notify -->
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">المستخدمين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> /
                صلاحيات المستخدمين</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
@if (session()->has('Add'))
    <script>
        window.onload = function() {
            notif({
                msg: " تم اضافة الرتبة بنجاح",
                type: "success"
            });
        }
    </script>
@endif
@if (session()->has('Edit'))
    <script>
        window.onload = function() {
            notif({
                msg: " تم تعديل الرتبة بنجاح",
                type: "success"
            });
        }
    </script>
@endif
@if (session()->has('Delete'))
    <script>
        window.onload = function() {
            notif({
                msg: " تم حذف الرتبة بنجاح",
                type: "error"
            });
        }
    </script>
@endif
<!-- row -->
<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card">
            @can('اضافة رتبة')
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                        <div class="col-sm-6 col-md-4 col-xl-3">
                                <a class="btn btn-outline-primary btn-block" href="{{ route('roles.create') }}">اضافة رتبة</a>
                            </div>
                    </div>
                </div>
                @endcan
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mg-b-0 text-md-nowrap table-hover ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $key => $role)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        @can('عرض رتبة')
                                            <a class="btn btn-success btn-sm"
                                                href="{{ route('roles.show', $role->id) }}">عرض</a>
                                        @endcan
                                        
                                        @can('تعديل رتبة')
                                            <a class="btn btn-primary btn-sm"
                                                href="{{ route('roles.edit', $role->id) }}">تعديل</a>
                                        @endcan
                                        @if ($role->name !== 'owner')
                                            @can('حذف رتبة')
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy',
                                                $role->id], 'style' => 'display:inline']) !!}
                                                {!! Form::submit('حذف', ['class' => 'btn btn-danger btn-sm']) !!}
                                                {!! Form::close() !!}
                                            @endcan
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--/div-->
</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Notify js -->
<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
@endsection
