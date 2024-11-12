@extends('layouts.app')
@php
    $session = session();
@endphp
@section('content')
  <style>
    body { font-family: Arial, sans-serif; padding: 20px; max-width: 1200px; margin: 0 auto; }
    .header {
      border-bottom: 2px solid black;
      padding-bottom: 10px;
      margin-bottom: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .table-container {
      overflow-x: auto;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    th {
      background-color: #f8f9fa;
      font-weight: bold;
    }
    tr:hover {
      background-color: #f5f5f5;
    }
    .status-badge {
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 14px;
      font-weight: 500;
    }
    .status-valide {
      background-color: #d4edda;
      color: #155724;
    }
    .status-rejete {
      background-color: #f8d7da;
      color: #721c24;
    }
    .btn, .btn-action {
      padding: 6px 12px;
      border-radius: 4px;
      text-decoration: none;
      font-size: 14px;
      cursor: pointer;
      border: none;
      display: inline-block;
    }
    .btn-primary {
      background-color: #007bff;
      color: white;
    }
    .btn-danger {
      background-color: #dc3545;
      color: white;
    }
    .btn-action {
      background-color: #6c757d;
      color: white;
    }
    .btn-action:hover {
      background-color: #5a6268;
      color: white;
      text-decoration: none;
    }
    .empty-state {
      text-align: center;
      padding: 40px;
      color: #6c757d;
    }
    .status-informed {
      background-color: #ffd700;
      color: #856404;
      padding: 4px 8px;
      border-radius: 4px;
      font-size: 12px;
      margin-left: 8px;
    }
  </style>

  <div class="table-container">
    @if($entretiens->count() > 0)
      <table>
        <thead>
          <tr>
            <th>Candidat</th>
            <th>Poste</th>
            <th>Date</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($entretiens as $entretien)
            <tr>
              <td>{{ $entretien->cv->dossier->candidat ?? 'N/A' }}</td>
              <td>{{ $entretien->cv->dossier->besoinPoste->poste->libelle ?? 'N/A' }}</td>
              <td>{{ date('d/m/Y', strtotime($entretien->date_entretien)) }}</td>
              <td>
                  @if($entretien->status == "valide")
                <span class="status-badge status-{{ $entretien->status }}">
                  {{ ucfirst($entretien->status) }}
                </span>
                @else
                  <span class="status-informed">non valide</span>
                @endif
              </td>
              <td>
                @if ($session->get('role') == 4)
                    @if (!$entretien->informer )
                        <a href="{{ route('entretien.informer', $entretien->id) }}" class="btn-action">
                            Informer
                        </a>
                    @else
                        <span class="status-informed">message envoye</span>
                    @endif
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @else
      <div class="empty-state">
        <h3>Aucun entretien enregistré</h3>
        <p>Commencez par créer un nouvel entretien</p>
      </div>
    @endif
  </div>
@endsection
