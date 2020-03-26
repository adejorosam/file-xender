@extends('layouts.app')
@section('title','Xend File | FileXender')
@section('content')
<div class="container">
    {!! Form::open(['action'=>'DocumentController@store', 'method' => 'POST', 'enctype'=>"multipart/form-data"]) !!}
<div class="form-group">
    {{Form::label('name',  'File Title')}}
    {{Form::text('name','', ['class' =>'form-control', 'placeholder' => "File Title"])}}
</div>
<div class="form-group">
    {{Form::label("Recipient's E-mail",  "Recipient's E-mail")}}
    {{Form::text('recipient_email','', ['class' =>'form-control', 'placeholder' => "Recipient's E-mail"])}}
</div>
<div class="form-group">
    <label for="">File Select</label>
    <input required type="file" class="form-control" name="file[]" multiple="multiple">
    <div class="progress">
        <div class="bar"></div >
        <div class="percent">0%</div >
    </div>
</div>



{{Form::submit('Submit', ['class'=>'btn btn-primary'])}}
{!! Form::close() !!}
</div>
@endsection

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script>
<script src="http://malsup.github.com/jquery.form.js"></script>
 
<script type="text/javascript">
 
    function validate(formData, jqForm, options) {
        var form = jqForm[0];
        if (!form.file.value) {
            alert('File not found');
            return false;
        }
    }
 
    (function() {
 
    var bar = $('.bar');
    var percent = $('.percent');
    var status = $('#status');
    console.log(percent);
 
    $('form').ajaxForm({
        beforeSubmit: validate,
        beforeSend: function() {
            status.empty();
            var percentVal = '0%';
            var posterValue = $('input[name=file[]]').fieldValue();
            bar.width(percentVal)
            percent.html(percentVal);
        },
        uploadProgress: function(event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            bar.width(percentVal)
            percent.html(percentVal);
        },
        success: function() {
            var percentVal = 'Wait, Saving';
            bar.width(percentVal)
            percent.html(percentVal);
        },
        complete: function(xhr) {
            status.html(xhr.responseText);
            alert('Uploaded Successfully');
            window.location.href = "/file-upload";
        }
    });
     
    })();
</script>