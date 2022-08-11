@if(count($errors) > 0)
@foreach($errors->all() as $error)  
<div class="badge badge-danger">
{{$error}}
</div>
<br>
@endforeach
@endif
@if(session('success'))

    <div style="font-size:12px" class="badge badge-success">
    {{session('success')}}
    </div>
@endif

@if(session('error'))

    <div style="font-size:12px" class="badge badge-danger">
    {{session('error')}}
    </div>
@endif
