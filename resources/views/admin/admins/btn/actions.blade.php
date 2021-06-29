<a  class=" btn btn-info" href="users/edit/{{$id}}">
    <i class="fa fa-edit"></i>
    {{ trans('admin.edit') }}
</a>
{{-- <a  class="btn btn-danger"
      href="{{ route('admins.users.destroy',$id) }}">
     <i class="fa fa-trash"></i>
    {{ trans('admin.delete') }}
</a> --}}
<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#del_admin{{ $id }}"> <i class="fa fa-trash"></i></button>
  
  <!-- Modal -->
  <div class="modal fade" id="del_admin{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{trans('admin.delete')}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
        {{--  Start Delete form --}}
        {!! Form::open(['route'=>['admins.users.destroy',$id],'method'=>'post']) !!}
        <div class="modal-body">
            {{ csrf_field() }}
            {!! Form::hidden('_method','delete') !!}
        <h4>{{trans('admin.delete_this',['name'=>$name])}}</h4>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info mx-2" data-dismiss="modal">{{trans('admin.close')}}</button>
          {!! Form::submit(trans('admin.yes'), ['class'=>'btn btn-danger']) !!}
        </div>
        {!! Form::close() !!}
        {{--  End Delete form --}}


      </div>
    </div>
  </div>




