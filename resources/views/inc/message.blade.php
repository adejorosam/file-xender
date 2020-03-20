@if (count($errors)>0)
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger">
            {{$error}}
        </div>
    @endforeach    
@endif

@if(session('success'))
<div class="alert alert-success">
    <p style="padding-left:600px;">{{session('success')}}</p>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
    {{session('error')}}
</div>
@endif
