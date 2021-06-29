@if(session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
@endif

@if($errors->all())
    @foreach($errors->all() as $error)
    <div class="alert alert-danger">
        {{$error}}
    </div>
    @endforeach
@endif
