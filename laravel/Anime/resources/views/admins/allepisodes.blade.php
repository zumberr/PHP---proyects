@extends('layouts.admin')


@section('content')


<div class="row">
    <div class="col">
      <div class="card">
        <div class="card-body">
            <div class="container">
                @if(session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                @endif
            </div>

            <div class="container">
              @if(session()->has('delete'))
                  <div class="alert alert-success">
                      {{ session()->get('delete') }}
                  </div>
              @endif
          </div>
          <h5 class="card-title mb-4 d-inline">Episodes</h5>
          <a  href="{{ route('episode.create') }}" class="btn btn-primary mb-4 text-center float-right">Create Episodes</a>

          <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">video</th>
                <th scope="col">thumbnail</th>
                <th scope="col">name</th>
                <th scope="col">show id</th>
                
                <th scope="col">delete</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($allEpisodes as $episode)
                  <tr>
                    <th scope="row">{{ $episode->id }}</th>
                    <td>
                        <video width="50" height="50" id="player" >
                            <source src="{{ asset('assets/videos/'.$episode->video.'') }}" type="video/mp4" />
                            <!-- Captions are optional -->
                            <track kind="captions" label="English captions" src="#" srclang="en" default />
                        </video>
                     </td>
                    <td><img width="50" height="50" src="{{ asset('assets/thumbnails/'.$episode->thumbnail.'') }}"></td>
                    <td>ep {{ $episode->episode_name }}</td>
                    <td> {{ $episode->show_id }}</td>
    
                    <td><a href="{{ route('episodes.delete', $episode->id) }}" class="btn btn-danger  text-center ">delete</a></td>
                  </tr> 
                @endforeach
             
             
            </tbody>
          </table> 
        </div>
      </div>
    </div>
  </div>

  @endsection