@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h1 class="h3">Comparaison CV avec profil talent</h1>
        </div>

        <div class="card-body">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2>Candidat: {{ $cv->dossier->candidat ?? 'N/A' }} - Poste: {{ $cv->dossier->besoinPoste->poste->libelle ?? 'N/A' }}</h2>
                    </div>
                </div>
            </div>

            <!-- Affichage du score global -->
            <div class="alert alert-info">
                <strong>Score de correspondance global: {{ $scoreGeneral ?? 'Non calculé' }}%</strong>
            </div>

            <!-- Formulaire de paramétrage des pondérations -->
            <div class="mt-4">
                <h4>Paramétrage des pondérations</h4>
                <form action="{{ route('cv.sendToCompare', $cv->id) }}" method="GET">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ponderExp" class="form-label">Pondération de l'expérience (%)</label>
                                <input type="number" name="ponderExp" id="ponderExp" class="form-control" value="{{ old('ponderExp', 70) }}" min="0" max="100" step="1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="ponderEtude" class="form-label">Pondération de l'étude (%)</label>
                                <input type="number" name="ponderEtude" id="ponderEtude" class="form-control" value="{{ old('ponderEtude', 30) }}" min="0" max="100" step="1">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Appliquer les pondérations</button>
                </form>
            </div>

            <div class="row">
                <!-- Profil requis (Talents requis pour le poste) -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3>Profil requis</h3>
                        </div>
                        <div class="card-body">
                            <div class="skill-match mb-4">
                                <ul class="list-unstyled">
                                    @foreach($talentsRequis as $talent)
                                        <p>{{ $talent->talent->libelle ?? 'Non spécifié' }} :</p>
                                        <li>
                                            - Expérience : {{ $talent->expmin ?? 'Non spécifiée' }} à {{ $talent->expmax ?? 'Non spécifiée' }} ans
                                        </li>

                                        <li>
                                            - Etude : {{ $talent->etude ?? 'Non spécifiée' }} ans
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profil candidat (Talents associés au CV) -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3>Profil candidat</h3>
                        </div>
                        <div class="card-body">
                            <div class="skill-match mb-4">
                                <ul class="list-unstyled">
                                    @foreach($talentsAssocies as $classification)
                                        <p>{{ $classification->talent->libelle ?? 'Non spécifié' }}</p>
                                        <li>
                                            - Expérience : {{ $classification->experience ?? 'Non spécifiée' }} ans
                                        </li>

                                        <li>
                                            - Etude : {{ $classification->experience ?? 'Non spécifiée' }} ans
                                        </li>

                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Affichage des scores individuels -->
            <div class="mt-4">
                <h4>Scores de correspondance par talent</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Talent</th>
                            <th>Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($scores as $score)
                            <tr>
                                <td>{{ $score['id_talent'] ?? 'Non spécifié' }}</td>
                                <td>{{ number_format($score['score'] * 100, 2) }}%</td> <!-- Affichage du score en pourcentage -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Boutons de validation ou rejet -->
            <!-- Remplacer la section des boutons de validation/rejet par : -->
            <div class="mt-4 text-center">
                <form action="{{ route('cv.updateStatus', $cv->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="valide">
                    <button type="submit" class="btn btn-success me-2">Valider la correspondance</button>
                </form>

                <form action="{{ route('cv.updateStatus', $cv->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="rejete">
                    <button type="submit" class="btn btn-danger me-2">Rejeter</button>
                </form>

                <a href="{{ route('cv.index') }}" class="btn btn-secondary">Retour</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .skill-match {
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 5px;
    }

    .skill-match h4 {
        color: #495057;
        margin-bottom: 15px;
    }

    .list-unstyled li {
        margin-bottom: 8px;
    }

    table th, table td {
        text-align: center;
    }
</style>
@endpush
