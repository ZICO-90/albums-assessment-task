
@extends('layouts.app')
@section('route')
<a class="navbar-brand" href="{{ url('/home') }}">
   create album
</a>
<a class="navbar-brand" href="{{ url('/albums') }}">
    albums
 </a>
@endsection
@section('css')
<script src="https://kit.fontawesome.com/1a57f12784.js"></script>
    <style>

.table-wrapper {
        background: #fff;
        padding: 20px 25px;
        margin: 30px 0;
		border-radius: 3px;
        box-shadow: 0 1px 1px rgba(0,0,0,.05);
    }
	.table-title {        
		padding-bottom: 15px;
		background: #333333;
		color: #fff;
		padding: 16px 30px;
		margin: -20px -25px 10px;
		border-radius: 3px 3px 0 0;
    }
    .table-title h2 {
		margin: 5px 0 0;
		font-size: 24px;
	}

    .table-title .btn-group {
		float: right;
	}






.box{
  background: tomato;
  height: 200px;
  width: 200px;
  position: relative;
}

.box i{
  position: absolute;
  right: 0;
  margin: 5px;
  font-size: 30px;
  cursor: pointer;
}


li {
    cursor: pointer;
}
.box i:hover{
  color: gray;
}

.box img{
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.box i.fa-trash{
    color: rgb(220, 217, 20);
}
    </style>
@endsection


@section('content')
<div class="container">
    <div class="table-wrapper">
        <div class="table-title">
          <div class="row">
            <div class="col-sm-6">
              <h2>albums ({{$album->name}}) by ({{$album->user->name}})</h2>
            </div>


          </div>
        </div>
    </div>
  <div class="row">
    @if($album->pictuers->count() > 0)
      @foreach ($album->pictuers as $item)
      <div class="col-lg-4 col-md-4 col-xs-4 thumb" id="thumb-{{$item->id}}">
        <ul class="nav navbar-nav d-inline-flex mr-auto">
            <li class="nav-item">
              <ul class="list-inline-mb-0">
                <a href="javascript:void(0);"  class="editGallery"  data-url="{{route('albums.update.gallery.ajax',$item->id)}}"  data-id="{{$item->id}}"  data-name="{{$item->name}}" data-bs-toggle="modal" data-bs-target="#editImage" >
                
                    <li class="list-inline-item">  <i data-toggle="tooltip" title="edit" class="fa fa-pencil"></i></li>
                </a>
                   
                <a href="{{route('albums.delete.gallery',$item->id)}}">
                    <li class="list-inline-item">  <i data-toggle="tooltip" title="delete"  class="fa fa-trash"></i></li>  
                   
                </a>
              </ul>
            </li>
          </ul>
        <div class="box">
            <img class="img-responsive" src="{{asset(Storage::url($item->url))}}" alt="">
        </div>
        <label>{{$item->name}}</label>
     </div>
      @endforeach
    @endif

  </div>
</div>
<!-- Delete Modal HTML -->
<div id="editImage" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editFormGallery">

        {{ method_field('PUT') }}
        @csrf
        <div class="modal-header">
          <h4 class="modal-title">edit images</h4>
        </div>
        <div class="modal-body">
              <div class="input-group">
                <span class="input-group-text">name image</span>
                <input type="text" aria-label="name"  readonly class="form-control inputTitle">
                <input type="text" aria-label="change" name="name" placeholder="change name here" class="form-control">
              </div>

              <div class="mb-3">
               <br>
                <input class="form-control" type="file" onchange="previewFile(this)" id="formFile">
                   <div class="box"  id="imagePreview" style="display: none">
                    <i class="fa fa-trash icon-trash"></i>
                        <img src="">
                   </div>
              </div>
        </div>
        <div class="modal-footer">
          <input type="button" class="btn btn-default" data-bs-dismiss="modal" value="Cancel">
          <input type="submit" class="btn btn-success" value="update">
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Edit Modal HTML -->
@endsection


@section('js')

<script src="{{asset('js/gallery.js')}}"></script>
@endsection