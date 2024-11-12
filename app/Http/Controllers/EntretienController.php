<?php

namespace App\Http\Controllers;

use App\Models\EntretienModel;
use App\Models\CvModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EntretienController extends Controller
{
    public function index(){
        $entretiens = EntretienModel::getAllEntretien();
        return view('entretien.index', compact('entretiens'));
    }

    public function create($id)
    {
        // Récupérer le CV avec ses relations (dossier et poste)
        $cv = CvModel::getCvById($id);

        if (!$cv) {
            return redirect()->route('entretien.index')->with('error', 'CV non trouvé.');
        }

        return view('entretien.create', compact('cv'));
    }
    public function selectCv()
    {
        $cvs = CvModel::get(); // Ajustez selon vos besoins
        $entretiens = EntretienModel::getAllEntretien();
        return view('entretien.index', compact('cvs','entretiens'));
    }

    public function store(Request $request, $id)
    {
        // Validation des données du formulaire
        $request->validate([
            'date_entretien' => 'required|date',
            'commentaire' => 'nullable|string',
            'status' => 'required|string',
        ]);

        try {
            // Créer l'entretien
            $data = $request->only(['date_entretien', 'commentaire', 'status']);
            $data['id_cv'] = $id;  // Utiliser $id au lieu de $cvId qui n'existe pas

            $entretien = new EntretienModel($data);
            $entretien->createEntretien($data);

            return redirect()->route('entretien.index')
                           ->with('success', 'Entretien ajouté avec succès.');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la création de l\'entretien : ' . $e->getMessage());
            return redirect()->back()
                           ->with('error', 'Une erreur est survenue lors de la création de l\'entretien.')
                           ->withInput();
        }
    }

    public function updateInformer(Request $request, $id) {
        try {
            $entretien = new EntretienModel();
            $entretien->setId($id);
            $entretien->setInformer(true);
            $entretien->updateInformer();

            return redirect()->route('entretien.index')
                           ->with('success', 'Statut mis à jour avec succès.');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour du statut : ' . $e->getMessage());
            return redirect()->back()
                           ->with('error', 'Une erreur est survenue lors de la mise à jour du statut.');
        }
    }
}
