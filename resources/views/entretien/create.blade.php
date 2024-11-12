@extends('layouts.app')

@section('content')
<style>
    body {
        font-family: Arial, sans-serif;
        padding: 20px;
        max-width: 800px;
        margin: 0 auto;
    }
    .header {
        border-bottom: 2px solid black;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    input, select, textarea {
        width: 100%;
        background: #f0f0f0;
        border: 1px solid #ddd;
        padding: 8px 12px;
        border-radius: 8px;
        margin-bottom: 10px;
    }
    button {
        background: black;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        cursor: pointer;
        margin-right: 10px;
    }
    .btn-reject {
        background: #dc3545;
    }
    .btn-validate {
        background: #28a745;
    }
</style>

<div class="header">
    <h1>Validation d'entretien</h1>
</div>

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="form-group">
    <form action="{{ route('entretien.store', ['id' => $cv->id]) }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Candidat</label>
            <input type="text" value="{{ $cv->dossier->candidat ?? 'N/A' }}" readonly>
        </div>

        <div class="form-group">
            <label>Poste</label>
            <input type="text" value="{{ $cv->dossier->besoinPoste->poste->libelle ?? 'N/A' }}" readonly>
        </div>

        <div class="form-group">
            <label>Date d'entretien</label>
            <input type="datetime-local" name="date_entretien" value="{{ old('date_entretien') }}" required>
            @error('date_entretien')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label>Commentaires détaillés</label>
            <textarea name="commentaire" rows="4" placeholder="Ajoutez vos observations...">{{ old('commentaire') }}</textarea>
            @error('commentaire')
                <div
                 class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <input type="hidden" name="status" id="status_input">

        <div class="button-group">
            <button type="submit" class="btn-validate" onclick="setStatus('valide')">
                Valider l'entretien
            </button>
            <button type="submit" class="btn-reject" onclick="setStatus('rejete')">
                Rejeter la candidature
            </button>
            <button type="button" style="background: white; color: black; border: 1px solid black;"
                    onclick="window.history.back()">
                Retour
            </button>
        </div>
    </form>
</div>

<script>
    function setStatus(status) {
        document.getElementById('status_input').value = status;
    }
</script>
@endsection
