@extends('layouts.main')

@section('content')

    <form action="{{route('eventSportifs.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="nom" class="form-label">Nom: </label>
            <input  class="form-control" id="nom" name="nom">
        </div>
        <div class="form-floating">
            <textarea class="form-control" placeholder="Description" id="description" name="description"></textarea>
            <label for="description">Description</label>
        </div>
        <div class="mb-3">
            <label for="lieu" class="form-label">Lieu: </label>
            <input  class="form-control" id="lieu" name="lieu">
        </div>
        <div class="mb-3">
            <label for="dateDebut" class="form-label">Date début: </label>
            <input  type="date" class="form-control" id="dateDebut" name="dateDebut">
        </div>
        <div class="mb-3">
            <label for="dateFin" class="form-label">Date fin: </label>
            <input  type="date" class="form-control" id="dateFin" name="dateFin">
        </div>
        <div class="mb-3">
            <label for="poster" class="form-label">Poster</label>
            <input class="form-control" type="file" id="poster" name="poster" accept="image/png, image/jpeg">
        </div>

        <a type="button" class="btn btn-secondary" href="{{route('eventSportifs.index')}}">Annuler</a>
        <button type="submit" class="btn btn-primary">Submit</button>

    </form>

@endsection
