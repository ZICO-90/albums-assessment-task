@extends('layouts.app')


 @section('route')
 <a class="navbar-brand" href="{{ url('/albums') }}">
    albums
 </a>
 @endsection
@section('content')
<div class="container">
                <style>
                    .container{
                        direction:rtl;
                    }
                    .form-group{
                        text-align: right;
                    }
                  .dz-progress{display:none;}
                    .dz-remove {
                      color: brown;
                      }
                </style>
            
    
                <h3 align="center">انشاء البوم جديد</h3>
                <br />
                <div class="form-group">
                    <label>اسم الالبوم</label>
                    <input type="text" class="form-control" name="album" form="dropzoneFrom">
                    <small class="form-text text-muted" id="album"></small>
                </div>
                <br />
                <form action="{{route('albums.store')}}" class="dropzone" id="dropzoneFrom" enctype='multipart/form-data'>
                    @csrf
                </form>
                <small id="emailHelp" class="form-text text-muted" id='files'></small>
                <small  class="form-text text-muted" id="name_photos"></small>
                <br />
                <div id="preview" style="background-color: rgba(248, 248, 248, 0.39);"></div>
                <br />
                    <div align="center">
                      <button type="button" class="btn btn-success" id="submit-all">اضف اللبوم</button>
                   </div>
       
 
     

</div>
@endsection

@section('js')
<script src="{{asset('js/dropzoneFrom.js')}}"></script>
@endsection