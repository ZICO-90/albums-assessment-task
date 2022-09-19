
@extends('layouts.app')

@section('route')
<a class="navbar-brand" href="{{ url('/home') }}">
   create album
</a>
@endsection
@section('css')
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

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
	.table-title .btn {
		color: #fff;
		float: right;
		font-size: 13px;
		border: none;
		min-width: 50px;
		border-radius: 2px;
		border: none;
		outline: none !important;
		margin-left: 10px;
	}
	.table-title .btn i {
		float: left;
		font-size: 21px;
		margin-right: 5px;
	}
	.table-title .btn span {
		float: left;
		margin-top: 2px;
	}
    table.table tr th, table.table tr td {
        border-color: #e9e9e9;
		padding: 12px 15px;
		vertical-align: middle;
    }

	table.table tr th:last-child {
		width: 100px;
	}
    table.table-striped tbody tr:nth-of-type(odd) {
    	background-color: #fcfcfc;
	}
	table.table-striped.table-hover tbody tr:hover {
		background: #f5f5f5;
	}
    table.table th i {
        font-size: 13px;
        margin: 0 5px;
        cursor: pointer;
    }	
    table.table td:last-child i {
		opacity: 0.9;
		font-size: 22px;
    margin: 0 5px;
    }
	table.table td a {
		font-weight: bold;
		color: #566787;
		display: inline-block;
		text-decoration: none;
		outline: none !important;
	}
	table.table td a:hover {
		color: #2196F3;
	}
	table.table td a.edit {
        color: #FFC107;
    }
    table.table td a.Delete {
        color: #6e0303;
    }
    table.table td i {
        font-size: 19px;
    }
	table.table .avatar {
		border-radius: 50%;
		vertical-align: middle;
		margin-right: 10px;
	}

    .hint-text {
        float: left;
        margin-top: 10px;
        font-size: 13px;
    }    

	/* Modal styles */
	.modal .modal-dialog {
		max-width: 400px;
	}
	.modal .modal-header, .modal .modal-body, .modal .modal-footer {
		padding: 20px 30px;
	}
	.modal .modal-content {
		border-radius: 3px;
	}
	.modal .modal-footer {
		background: #ecf0f1;
		border-radius: 0 0 3px 3px;
	}
    .modal .modal-title {
        display: inline-block;
    }
	.modal .form-control {
		border-radius: 2px;
		box-shadow: none;
		border-color: #dddddd;
	}
	.modal textarea.form-control {
		resize: vertical;
	}
	.modal .btn {
		border-radius: 2px;
		min-width: 100px;
	}	
	.modal form label {
		font-weight: normal;
	}	

</style>
@endsection



@section('content')


<div class="container">
  <div class="table-wrapper">
    <div class="table-title">
      <div class="row">
        <div class="col-sm-6">
          <h2>albums({{$ablumsUser->name}})</h2>
        </div>

      </div>
    </div>
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>Name album</th>
          <th>Total pictuers</th>
          <th>date</th>
          <th></th>
        </tr>
      </thead>
      <tbody>

        @foreach ($ablumsUser->albums as $item)
        <tr>
          <td>{{$item->name}}</td>
          <td>{{$item->pictuers->count()}}</td>
          <td>{{$item->created_at}}</td>
          <td> 
            <a href="javascript:void(0);" class="moveLink" data-showMove="show-move{{$item->id}}"  data-url="{{route('albums.move',$item->id)}}"  data-filter="{{$item->id}}"  data-name-modal="{{$item->name}}" data-bs-toggle="modal" data-bs-target="#moveAlbumModal" ><i class="material-icons" data-toggle="tooltip" title="move">&#xebbd;</i></a>
            @if($item->pictuers->count() > 0)
            <a href="javascript:void(0);"  class="Delete" data-bs-toggle="modal" data-bs-target="#delete-album-modal" data-url="{{route('albums.delete.album',$item->id)}}" ><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
            @else
            <a href="{{route('albums.delete.album',$item->id)}}"><i style="color: rgb(72, 210, 30)" class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>

            @endif
            <a href="{{route('albums.gallery',$item->id)}}" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="edit">&#xe745;</i></a>
          </td>
        </tr>
        @endforeach
        
      </tbody>
    </table>
  </div>
</div>

<div id="moveAlbumModal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formMovetNameAlbum">
        {{ method_field('PUT') }}
        @csrf
        <div class="modal-header">
          <h4 class="modal-title">move album </h4>
        
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>from</label>
            <input type="text" class="form-control album-input"  readonly required>
          </div>
          <label>To</label>
          <select name="to_album" id="selected" class="form-select form-select-sm" aria-label=".form-select-sm example">
            @foreach ($list as $key => $val)
            <option value="{{$key}}">{{$val}}</option>
            @endforeach
          </select>
        </div>

        <div class="modal-footer">
          <input type="button" class="btn btn-default" data-bs-dismiss="modal" value="Cancel">
          <input type="submit" class="btn btn-info" id="is-moved" value="save">
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Delete Modal HTML -->
<div id="delete-album-modal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="delete-album-form">
        <div class="modal-header">
          <h4 class="modal-title">Delete albums</h4>
          
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete the album?</p>
          <p class="text-warning"><small>All photos will be deleted</small></p>
        </div>
        <div class="modal-footer">
          <input type="button" class="btn btn-default" data-bs-dismiss="modal" value="Cancel">
          <input type="submit" class="btn btn-danger" value="Delete">
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Edit Modal HTML -->
<div id="addEmployeeModal" class="modal fade"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form>
        <div class="modal-header">
          <h4 class="modal-title">Add Model</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Models</label>
            <input type="text" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Status</label>
            <input type="email" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Schedule</label>
            <textarea class="form-control" required></textarea>
          </div>
          <div class="form-group">
            <label>Amount</label>
            <input type="text" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <input type="button" class="btn btn-default" ata-bs-dismiss="modal" aria-label="Close">
          <input type="submit" class="btn btn-success" value="Add">
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Edit Modal HTML -->
 @endsection


@section('js')

<script src="{{asset('js/movedAlbum.js')}}"></script>
@endsection