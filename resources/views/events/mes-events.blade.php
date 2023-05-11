
@extends('layouts.main')
@section('content')
    @if(Auth::user()->id !=null)
        <a type="button" href="{{route('eventSportifs.create')}}" class="btn btn-primary">Ajouter</a>
    @endif
    @include('layouts.liste-events')
@endsection
