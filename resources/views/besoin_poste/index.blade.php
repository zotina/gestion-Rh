@extends('layouts.app')

@section('content')
    <h1>Liste des Besoins Talent</h1>
    @php
    $session = session();
    @endphp

    <!-- Formulaire de recherche -->
    <form method="GET" action="{{ route('besoin_poste.index') }}">
        <div class="row">
            <div class="col-md-4">
                <label for="poste">Poste</label>
                <select name="poste" id="poste" class="form-control">
                    <option value="">Sélectionnez un poste</option>
                    @foreach($postes as $poste)
                        <option value="{{ $poste->id }}" {{ request('poste') == $poste->id ? 'selected' : '' }}>{{ $poste->libelle }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label for="departement">Département</label>
                <select name="departement" id="departement" class="form-control">
                    <option value="">Sélectionnez un département</option>
                    @foreach($departements as $departement)
                        <option value="{{ $departement->id }}" {{ request('departement') == $departement->id ? 'selected' : '' }}>{{ $departement->libelle }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Rechercher</button>
            </div>
        </div>
    </form>

    <br>

    @if(empty($besoins_talent))
        <p>Aucun besoin trouvé.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Poste</th>
                    <th>Département</th>
                    <th>Urgence</th>
                    <th>Date Requise</th>
                    <th>Status</th>
                    @if ($session->get('role') == 3) <!-- Vérifiez si le rôle est 'PDG' -->
                    <th>Actions</th>
                    @endif

                </tr>
            </thead>
            <tbody>
                @foreach($besoins_talent as $besoin)
                    <tr>
                        <td>{{ $besoin->poste }}</td>
                        <td>{{ $besoin->departement }}</td>
                        <td>{{ $besoin->urgence }}</td>
                        <td>{{ $besoin->date_requis }}</td>
                        <td>{{ $besoin->status ? 'En cours' : 'Inactif' }}</td>
                        @if ($session->get('role') == 3)
                        <td>
                            <a href="{{ route('employe', $besoin->id) }}" class="btn btn-warning">Analyse</a>
                            {{-- <form action="{{ route('besoin_poste.destroy', $besoin->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce besoin?')">Supprimer</button>
                            </form> --}}
                        </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
