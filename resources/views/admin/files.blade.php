@extends('layouts.app')
@section('title', 'Available files | Findworka')
@section('content')
<div class="container-fluid mt-5">
    <div class="card card-register">
                    <div class="card-header">
                        <h5 class="card-title">Available files</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                                <table class="table">
                                    <thead class=" text-primary">
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Transaction number
                                        </th>
                                        <th>
                                            E-mail Adress
                                        </th>
                                        <th>
                                            Date Sent
                                        </th>
                                        <th class="text"></th>
                                    </thead>
                                    <tbody>
                                        @foreach($files as $file)
                                        <tr>
                                            <td>
                                                {{$file->name}}
                                            </td>
                                            <td>
                                                {{$file->transaction_id}} 
                                            </td>
                                            <td>
                                                {{$file->recipient_email}} 
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($file->created_at)->format('d/m/Y')}}
                                            </td>
                                           
                                            <td class="text">
                                                <a href="{{url('/file')}}/{{$file->id}}" class="btn btn-warning">VIEW FILE</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
</div>
@endsection