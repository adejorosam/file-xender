@extends('layouts.app')
@section('title','Xend File | FileXender')
@section('content')
<div class="container">
<h1> My Profile </h1>
{!! Form::open(['action'=>['DashboardController@update', Auth::user()->id], 'method' => 'POST', 'enctype'=>"multipart/form-data"]) !!}
        <div class="form-group">
            {{Form::label('name',  'Your Name')}}
            {{Form::text('name', Auth::user()->name, ['class' =>'form-control', 'placeholder' => "Your Name"])}}
        </div>
        <div class="form-group">
            {{Form::label('email',  'E-mail Address')}}
            {{Form::text('email', Auth::user()->email, ['class' =>'form-control', 'placeholder' => "E-mail Address"])}}
        </div>
        <div class="form-group row">
            <label for="password" class="col-md-7 col-form-label text-md-left">{{ __('Password') }}</label>
            <div class="col-md-6">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
            </div>
        </div>
         {{-- <div class="form-group">
            <label for="image">Upload Image</label>
            <input type="file" class="form-control" name="image" value="{{Auth::user()->image}}"> 
        </div>  --}}
        {{Form::hidden('_method', 'PUT')}}
        {{Form::submit('Update', ['class'=>'btn btn-primary'])}}

{!! Form::close() !!}
</div>
@endsection