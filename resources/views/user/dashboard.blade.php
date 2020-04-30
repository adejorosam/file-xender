@extends('layouts.app')
@section('content')
<style>
    .search {
  width: 100%;
  position: relative;
  display: flex;
}

.searchTerm {
  width: 100%;
  border: 3px solid #00B4CC;
  border-right: none;
  padding: 5px;
  height: 20px;
  border-radius: 5px 0 0 5px;
  outline: none;
  color: #9DBFAF;
}

.searchTerm:focus{
  color: #00B4CC;
}

.searchButton {
  width: 40px;
  height: 36px;
  border: 1px solid #00B4CC;
  background: #00B4CC;
  text-align: center;
  color: #fff;
  border-radius: 0 5px 5px 0;
  cursor: pointer;
  font-size: 20px;
}

/*Resize the wrap to see the search bar change!*/
.wrap{
  width: 30%;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
</style>

<div class="container-fluid mt-5">
    <div class="wrap">
        <form action="/search" method="GET">
        <div class="search form-group" >
           <input type="text" name="transaction_id" class="searchTerm" placeholder="Transaction ID">
           <input type="text" name="e-mail" class="searchTerm" placeholder="E-mail">
           <button type="submit" class="searchButton">
             <i class="fa fa-search"></i>
          </button>
        </div>
        </form>
     </div>
     
    <div class="card card-register">
        
                    <div class="card-header">
                        <h5 class="card-title">Available files</h5>
                    </div>
                   
                    <div class="card-body">
                        <div class="table-responsive">
                            
                                <table class="table">
                                    @if(count($files)>0)
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
                                                {{$file->title}}
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
                                           

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @else
                                <a href="dashboard"> Go back </a>
                                    <p> No search result </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
</div>
@endsection
