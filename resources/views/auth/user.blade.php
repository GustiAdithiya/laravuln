@section('js')
<script type="text/javascript">
  $(document).ready(function() {
    $('#table').DataTable({
      "iDisplayLength": 50
    });

} );
</script>
@stop
@extends('layouts.app')

@section('content')
{{-- sini --}} 
<form class="form" action="{{ route('search') }}">
  
  <div class="form-group w-100 mb-3">
      <label for="search" class="d-block mr-2">Pencarian</label>
      <input type="text" name="search" class="form-control w-75 d-inline" id="search" placeholder="Masukkan keyword">
      <button type="submit" class="btn btn-primary mb-1">Cari</button>
  </div>
</form>
@if($keyword != "")
<!-- <h3>Pencarian : {{$keyword}}</h3> -->
<!-- code yang salah -->
<h3>Pencarian : {!! $keyword !!}</h3>
@else

@endif

{{-- KOMEN LINE 25-26 UNTUK MEMBUAT SEARCH YANG BENAR --}}
{{-- @php
    echo $datas;
@endphp --}}

<br><br>
<div class="row">

{{-- end   --}}
<div class="col-lg-2">
    <a href="{{ route('user.create') }}" class="btn btn-primary btn-rounded btn-fw"><i class="fa fa-plus"></i> Tambah User</a>
  </div>
    <div class="col-lg-12">
                  @if (Session::has('message'))
                  <div class="alert alert-{{ Session::get('message_type') }}" id="waktu2" style="margin-top:10px;">{{ Session::get('message') }}</div>
                  @endif
                  </div>
</div>
<div class="row" style="margin-top: 20px;">
<div class="col-lg-12 grid-margin stretch-card">
              <div class="card">  

                <div class="card-body">
                  <h4 class="card-title">Data User</h4>
                  
                  <div class="table-responsive">
                    <table id="table" class="table table-striped">
                      <thead>
                        <tr>
                          <th>
                            Name
                          </th>
                          <th>
                            Username
                          </th>
                          <th>
                            Email
                          </th>
                          <th>
                            Created At
                          </th>
                          <th>
                            Action
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        {{-- HILANGKAN KOMEN PADA LINE 72-114 UNTUK MEMBUAT SEARCH YANG BENAR --}}
                      @foreach($datas as $data)
                        <tr>
                          <td class="py-1">
                          @if($data->gambar)
                            <img src="{{url('images/user', $data->gambar)}}" alt="image" style="margin-right: 10px;" />
                          @else
                            <img src="{{url('images/user/default.png')}}" alt="image" style="margin-right: 10px;" />
                          @endif


                            {!! $data->name !!}
                          </td>
                          <td>
                          <a href="{{route('user.show', $data->id)}}"> 
                          {{$data->username}}
                          </a>
                          </td>
                          <td>
                            {{$data->email}}
                          </td>
                          <td>
                            {{$data->created_at}}
                          </td>
                          <td>
                           <div class="btn-group dropdown">
                          <button type="button" class="btn btn-success dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action
                          </button>
                          <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 30px, 0px);">
                            <a class="dropdown-item" href="{{route('user.edit', $data->id)}}"> Edit </a>
                            <form action="{{ route('user.destroy', $data->id) }}" class="pull-left"  method="post">
                            {{ csrf_field() }}
                            {{ method_field('delete') }}
                            <button class="dropdown-item" onclick="return confirm('Anda yakin ingin menghapus data ini?')"> Delete
                            </button>
                          </form>
                           
                          </div>
                        </div>
                          </td>
                        </tr>
                      @endforeach
                      </tbody>
                    </table>
                  </div>
                  {{-- {!! $datas->links() !!} --}}
                </div>
              </div>
            </div>
          </div>
@endsection