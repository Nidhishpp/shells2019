@extends('layouts.admin')
@section('title','SHELLS2k19 | Admin')

@section('content')


    <!-- Header -->
    <div class="header pb-8 pt-2 pt-md-5">
     
      <div class="container">
         
        <div class="header-body">
          <h1 class="text-center text-white">EVENT DOWNLOAD</h1>
          <!-- Card stats -->
          <div class="row">
              @foreach ($events as $event)
              <div class="col-md-4 my-3">
                <div class="card" style="min-height: 200px;">
                    <div class="card-body">
                      <h1 class="card-title" style="margin-bottom: 0px;">{{$event->name}}</h4>
                      <h5 class="card-title">{{$event->info}}</h5>
                       <a href="/eventdetails/{{$event->id}}" class="btn btn-success mt-5"> Download </a>
                    </div>
                  </div>
                </div>    
                  @endforeach 
          </div>
          

        </div>
      </div>
    </div>

    </div>
  </div>

@endsection
