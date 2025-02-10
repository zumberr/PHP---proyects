@extends('layouts.admin')


@section('content')


<div class="row">
    <div class="col-md-3">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Shows</h5>
          <!-- <h6 class="card-subtitle mb-2 text-muted">Bootstrap 4.0.0 Snippet by pradeep330</h6> -->
          <p class="card-text">number of shows: {{ $shows }}</p>
         
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Episodes</h5>
          
          <p class="card-text">number of episodes: {{ $episodes }}</p>
          
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Genres</h5>
          
          <p class="card-text">number of genres: {{ $categories }}</p>
          
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Admins</h5>
          
          <p class="card-text">number of admins: {{ $admins }}</p>
          
        </div>
      </div>
    </div>
  </div>

  @endsection