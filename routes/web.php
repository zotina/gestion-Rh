<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Annonce_communicationController;
use App\Http\Controllers\AnnonceController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Besoin_posteController;
use App\Http\Controllers\Classification_cvController;
use App\Http\Controllers\CommunicationController;
use App\Http\Controllers\ContratController;
use App\Http\Controllers\Contrat_cvController;
use App\Http\Controllers\CvController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\Departement_managerController;
use App\Http\Controllers\DossiersController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\EntretienController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\Model_communicationController;
use App\Http\Controllers\Model_exoController;
use App\Http\Controllers\PostesController;
use App\Http\Controllers\Postes_departController;
use App\Http\Controllers\PrioriteController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\TalentController;
use App\Http\Controllers\Talent_poste_besoinController;

// Routes for CRUD operations
Route::get('/', function () {
    return view('auth.login');
});

Route::get('besoin_poste', [Besoin_posteController::class, 'index'])->name('besoin_poste.index');
Route::get('besoin_poste/create', [Besoin_posteController::class, 'create'])->name('besoin_poste.create');
Route::post('besoin_poste', [Besoin_posteController::class, 'store'])->name('besoin_poste.store');
Route::get('besoin_poste/{id}/edit', [Besoin_posteController::class, 'edit'])->name('besoin_poste.edit');
Route::put('besoin_poste/{id}', [Besoin_posteController::class, 'update'])->name('besoin_poste.update');
Route::delete('besoin_poste/{id}', [Besoin_posteController::class, 'destroy'])->name('besoin_poste.destroy');
Route::get('besoin_poste/{id}/analyse', [Besoin_posteController::class, 'analyse'])->name('besoin_poste.analyse');

Route::get('/contrat', [ContratController::class, 'index'])->name('contrat.index');
Route::get('contrat/create', [ContratController::class, 'create'])->name('contrat.create');
Route::get('contrat/{id}/edit', [ContratController::class, 'edit'])->name('contrat.edit');
Route::put('contrat/{id}', [ContratController::class, 'update'])->name('contrat.update');
Route::delete('contrat/{id}', [ContratController::class, 'destroy'])->name('contrat.destroy');
Route::get('/contrat/showRenewalForm/{id}', [ContratController::class, 'showRenewalForm'])->name('contrat.showRenewalForm');
Route::get('/contrat/showEssaiForm', [ContratController::class, 'showEssaiForm'])->name('contrat.showEssaiForm');
Route::post('/contrat/essai', [ContratController::class, 'storeEssai'])->name('contrat.essai.store');
Route::post('/contrat/employe', [ContratController::class, 'storeContrat'])->name('contrat.employe.store');


Route::put('/dossiers/refuser/{id}', [DossiersController::class, 'refuser'])->name('dossiers.refuser');
Route::get('/dossier/{id}/evaluate', [DossiersController::class, 'create'])->name('dossier.evaluate');


Route::get('cv', [CvController::class, 'index'])->name('cv.index');
Route::get('cv/create', [CvController::class, 'create'])->name('cv.create');
Route::post('cv', [CvController::class, 'store'])->name('cv.store');
Route::get('cv/{id}/edit', [CvController::class, 'edit'])->name('cv.edit');
Route::put('cv/{id}', [CvController::class, 'update'])->name('cv.update');
Route::delete('cv/{id}', [CvController::class, 'destroy'])->name('cv.destroy');
Route::get('cv/evaluer/{id}', [Classification_cvController::class, 'create'])->name('cv.evaluer');
Route::put('cv/evaluer/{id}', [Classification_cvController::class, 'store'])->name('evaluation.store');
Route::get('cv/comparer/{id}', [CvController::class, 'compareForm'])->name('cv.sendToCompare');
Route::put('cv/{id}/update-status', [CvController::class, 'updateComparaisonStatus'])->name('cv.updateStatus');
Route::put('cv/{id}/update-informer', [CvController::class, 'updateInformer'])->name('cv.informer');
// Ajouter cette route avec les autres routes de CV

Route::get('dossiers', [DossiersController::class, 'index'])->name('dossiers.index');
Route::get('dossiers/create', [DossiersController::class, 'create'])->name('dossiers.create');
Route::post('dossiers', [DossiersController::class, 'store'])->name('dossiers.store');
Route::get('dossiers/{id}/edit', [DossiersController::class, 'edit'])->name('dossiers.edit');
Route::put('dossiers/{id}', [DossiersController::class, 'update'])->name('dossiers.update');
Route::delete('dossiers/{id}', [DossiersController::class, 'destroy'])->name('dossiers.destroy');
Route::put('/dossiers/refuser/{id}', [DossiersController::class, 'refuser'])->name('dossiers.refuser');
Route::get('/dossier/{id}/evaluate', [DossiersController::class, 'create'])->name('dossier.evaluate');

Route::get('employe/{id?}', [EmployeController::class, 'index'])->name('employe');
Route::get('employe/create', [EmployeController::class, 'create'])->name('employe.create');
Route::post('employe', [EmployeController::class, 'store'])->name('employe.store');
Route::get('employe/{id}/edit', [EmployeController::class, 'edit'])->name('employe.edit');
Route::put('employe/{id}', [EmployeController::class, 'update'])->name('employe.update');
Route::delete('employe/{id}', [EmployeController::class, 'destroy'])->name('employe.destroy');
Route::get('employe/promotion/{id_employe}/{candidat}/{postePromotion}', [EmployeController::class, 'employePromotion'])->name('employe.promotion');

Route::get('promotion', [PromotionController::class, 'index'])->name('promotion.index');
Route::get('promotion/create', [PromotionController::class, 'create'])->name('promotion.create');
Route::post('promotion', [PromotionController::class, 'store'])->name('promotion.store');
Route::get('promotion/{id}/edit', [PromotionController::class, 'edit'])->name('promotion.edit');
Route::put('promotion/{id}', [PromotionController::class, 'update'])->name('promotion.update');
Route::delete('promotion/{id}', [PromotionController::class, 'destroy'])->name('promotion.destroy');
Route::put('/promotion/{id}/valider', [PromotionController::class, 'updateStatus'])->name('promotion.updateStatus');


// Route::get('test', [TestController::class, 'index'])->name('test.index');
// Route::get('testDataSend', [TestController::class, 'testDataSend'])->name('test.testDataSend');


// Route::get('test/create', [TestController::class, 'create'])->name('test.create');
// Route::post('test', [TestController::class, 'store'])->name('test.store');
// Route::get('test/{id}/edit', [TestController::class, 'edit'])->name('test.edit');
// Route::get('test/{id}', [TestController::class, 'update'])->name('test.update');
// Route::delete('test/{id}', [TestController::class, 'destroy'])->name('test.destroy');



Route::get('loginPage', [AdminController::class, 'loginPage'])->name('loginPage');
Route::post('login', [AdminController::class, 'login'])->name('login');
Route::get('logout', [AdminController::class, 'logout'])->name('logout');
Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');


Route::get('annonce', [AnnonceController::class, 'index'])->name('annonce.index');
Route::get('annonce/{id?}', [AnnonceController::class, 'create'])->name('annonce.create');
Route::post('annonce', [AnnonceController::class, 'store'])->name('annonce.store');

Route::post('/annonce_communication/batch', [Annonce_communicationController::class, 'storeBatch'])->name('annonce_communication.storeBatch');
Route::get('publicite', [Annonce_communicationController::class, 'publicite'])->name('annonce_communication.publicite');


// Route::post('/test/batch', [TestController::class, 'testBatch'])->name('test.testBatch');
Route::get('/evaluation/{id}/create', [Classification_cvController::class, 'create'])
->name('classification_cv.evaluate');

Route::put('/evaluation/{id}', [Classification_cvController::class, 'store'])
->name('classification_cv.store');

Route::get('/entretien/create/{id}', [EntretienController::class, 'create'])->name('entretien.create');
Route::get('/entretien/select-cv/', [EntretienController::class, 'selectCv'])->name('entretien.select-cv');
Route::post('/entretien/{id}', [EntretienController::class, 'store'])->name('entretien.store');
Route::get('/entretien', [EntretienController::class, 'index'])->name('entretien.index');
Route::get('/entretien/{id}/update-informer', [EntretienController::class, 'updateInformer'])->name('entretien.informer');




use App\Http\Controllers\Test\TestCandidateController;
use App\Http\Controllers\Test\TestCandidateFileController;
use App\Http\Controllers\Test\TestController;
Route::resource('/test-candidate', TestCandidateController::class);
Route::get('/test', [TestController::class, 'index']);
Route::get('/test/create', [TestController::class, 'create']);
Route::get('/test/form1', [TestController::class, 'form1']);
Route::get('/test/form2', [TestController::class, 'form2']);
Route::get('/test/form3', [TestController::class, 'form3']);
Route::get('/test/pdf/{id}', [TestCandidateFileController::class, 'download_pdf']);
Route::get('/test/{id}', [TestController::class, 'show']);
Route::post('/test/store1', [TestController::class, 'store1']);
Route::post('/test/store2', [TestController::class, 'store2']);
Route::post('/test/store3', [TestController::class, 'store3']);
Route::post('/test/store3', [TestController::class, 'store3']);
Route::delete('/test/{id}', [TestController::class, 'destroy']);
Route::get('/test-candidate-file/test/{id}', [TestCandidateFileController::class, 'download_test']);
Route::get('/test-candidate-file/cv/{id}', [TestCandidateFileController::class, 'download_cv']);
