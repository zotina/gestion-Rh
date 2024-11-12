@extends('layouts.app')

@section('content')
<html>
<head>
  <title>Contrat d'Essai</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 20px; max-width: 800px; margin: 0 auto; }
    .header { border-bottom: 2px solid black; padding-bottom: 10px; margin-bottom: 20px; }
    .form-group { margin-bottom: 20px; }
    .info-section {
      border: 1px solid #ddd;
      padding: 15px;
      margin: 15px 0;
      border-radius: 8px;
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
    .evaluation-item {
      margin: 10px 0;
      padding: 10px;
      background: #f5f5f5;
      border-radius: 8px;
    }
    .checklist-item {
      display: flex;
      align-items: center;
      margin: 10px 0;
    }
    .checklist-item input[type="checkbox"] {
      width: auto;
      margin-right: 10px;
    }
  </style>
</head>
<body>
  <div class="header">
    <h1>Contrat d'Essai</h1>
  </div>

  <form action="{{ route('contrat.essai.store') }}" method="POST">
    @csrf
    <div class="form-group">
      <div class="info-section">
        <h3>Informations employé</h3>

        <!-- Nom complet de l'employé, provenant du dossier -->
        <label for="employee">Nom complet</label>
        <select id="employee" name="employee" onchange="updatePoste(this)">
            @foreach($entretiensValides as $entretien)
              <option value="{{ $entretien->cv->dossier->candidat }}"
                      {{ $loop->first ? 'selected' : '' }}>
                {{ $entretien->cv->dossier->candidat }}
              </option>
            @endforeach
        </select>

        <!-- Poste actuel, provenant du CV -->
        <label>Poste actuel</label>
        <input type="text" id="poste" value="{{ $entretiensValides->first()->cv->dossier->besoinPoste->poste->libelle ?? 'Non renseigné' }}" readonly>

        <!-- Date d'entrée, provenant du dossier -->
        <label>Date d'entrée</label>
        <input type="date" value="{{ $entretiensValides->first()->cv->dossier->date_reception ?? '2023-01-01' }}">
      </div>

      <div class="info-section">
        <h3>Détails du renouvellement</h3>

        <!-- Type de contrat (dynamique) -->
        <label>Type de contrat</label>
        <select name="type_contrat">
          @foreach($contrats as $contrat)
            <option value="{{ $contrat->libelle }}">{{ $contrat->libelle }}</option>
          @endforeach
        </select>

        <label>Nouvelle durée (si CDD)</label>
        <select name="periode">
          <option value="6">6 mois</option>
          <option value="12">1 an</option>
          <option value="24">2 ans</option>
        </select>

        <label>Salaire proposé</label>
        <input type="text" name="salaire_propose" placeholder="Montant annuel">
      </div>

      <label>Commentaires</label>
      <textarea name="notes_sup" rows="4" placeholder="Ajoutez vos commentaires sur le renouvellement..."></textarea>
    </div>

    <div class="actions">
      <button type="submit">Valider le renouvellement</button>
      <button type="button" style="background: #666;">Ne pas renouveler</button>
    </div>
  </form>
</body>
</html>

<script>
    // Fonction pour mettre à jour le poste actuel en fonction du candidat sélectionné
    function updatePoste(selectElement) {
        var candidateName = selectElement.value; // Nom du candidat sélectionné
        var posteElement = document.getElementById('poste'); // Élément du poste à mettre à jour

        // Récupérer tous les entretiens valides envoyés depuis PHP
        var selectedCandidate = @json($entretiensValides);

        // Afficher les données pour débogage
        console.log('Données entretiensValides:', selectedCandidate);
        console.log('Nom du candidat sélectionné:', candidateName);

        // Trouver l'entretien correspondant au candidat sélectionné
        var entretien = selectedCandidate.find(function(entretien) {
            console.log('Vérification de candidat:', entretien.cv.dossier.candidat);
            return entretien.cv.dossier.candidat.trim().toLowerCase() === candidateName.trim().toLowerCase();
        });

        // Affichage du résultat de la recherche
        console.log('Entretien trouvé:', entretien);

        // Si l'entretien est trouvé et qu'il a un poste associé
        if (entretien && entretien.cv.dossier.besoin_poste && entretien.cv.dossier.besoin_poste.poste) {
            // Mettre à jour le champ "poste" avec le libellé du poste
            posteElement.value = entretien.cv.dossier.besoin_poste.poste.libelle;
        } else {
            // Si le poste est introuvable ou non renseigné
            posteElement.value = 'Non renseigné';
        }
    }

    // Pour initialiser correctement la valeur du "poste" au chargement de la page (pour la première sélection)
    window.onload = function() {
        var firstEmployeeSelect = document.getElementById('employee');
        if (firstEmployeeSelect) {
            updatePoste(firstEmployeeSelect); // Appeler la fonction pour mettre à jour dès le chargement
        }
    };
</script>

@endsection
