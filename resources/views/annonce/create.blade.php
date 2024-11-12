@extends('layouts.app')

@section('content')
    <h1>Créer un Annonce</h1>

    <form action="{{ route('annonce.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <input type="hidden" class="form-control" id="id" name="id" />
        </div>
        <div class="form-group">
            <label for="id_besoin_poste">On a besoins de </label>
            @foreach($besoins as $besoin_poste)
                <p>{{ $besoin_poste->poste }}</p>
                <br>
                <p>{{ $besoin_poste->departement }}</p>
                <input type="hidden" class="form-control" id="id_besoin_poste" name="id_besoin_poste" value="{{ $besoin_poste->id }}" />

                <input type="hidden" class="form-control" id="is_validate" name="is_validate" value="true" />
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

@endsection
