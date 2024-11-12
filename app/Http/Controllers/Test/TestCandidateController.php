<?php

namespace App\Http\Controllers\Test;

use App\Models\Test\TestCandidate;
use App\Models\Test\TestCriterionCandidate;
use App\Models\Test\TestPointCandidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestCandidateController
{
    private $url = '/test-candidate';
    private $list_view = 'pages.test-candidate.list';
    private $form_view = 'pages.test-candidate.form';
    private $score_view = 'pages.test-candidate.score';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view($this->list_view)->with([
            'data' => DB::table('v_test_candidate')->get(),
            'template_url' => $this->url
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view($this->form_view)->with([
            'item' => null,
            'candidates' => DB::table('cv')->join('dossiers AS d', 'cv.id_dossier', '=', 'd.id')->pluck('d.candidat','cv.id'),
            'tests' => DB::table('test')->pluck('title', 'id'),
            'template_url' => $this->url,
            'form_action' => '/test-candidate',
            'form_method' => 'POST',
            'form_title' => 'Réception de Test'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id-candidate' => 'required|exists:cv,id',
            'id-test' => 'required|exists:test,id',
            'date-reception' => 'required|date',
            'file' => 'required|max:4096'
        ]);

        $file = $request->file('file');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(storage_path('app/test-candidate'), $filename);

        $images[] = 'test-candidate/'.$filename;

        $test = new TestCandidate();
        $test->id_cv_candidate = trim($request->input('id-candidate'));
        $test->id_test = trim($request->input('id-test'));
        $test->date_received = trim($request->input('date-reception'));
        $test->file = $filename;

        $test->save();

        return redirect($this->url)->with('success', 'Réception de Test effectuée avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        DB::table('test_candidate')->where('id', $id)->update(['is_communication_send' => true]);
        return redirect('/test-candidate');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $test = DB::table('test_candidate')->where('id', $id)->first();

        return view($this->score_view)->with([
            'item' => $id,
            'test_item' => $test->id_test,
            'test_requirements' => explode(';', DB::table('test')->where('id', $test->id_test)->first()->requirements),
            'test_points' => DB::table('test_point')->where('id_test', $test->id_test)->get(),
            'test_criteria' => DB::table('test_criterion')->where('id_test', $test->id_test)->get(),
            'template_url' => $this->url,
            'form_action' => '/test-candidate/'.$id,
            'form_method' => 'PUT',
            'form_title' => 'Vérification de Dossier'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $test = DB::table('test_candidate')->where('id', $id)->first();
        $test_requirements = explode(';', DB::table('test')->where('id', $test->id_test)->first()->requirements);

        $request->validate([
            'requirements' => 'required|array|size:'.count($test_requirements),
            'criteria' => 'required|array',
            'criteria.*' => 'required|numeric',
            'points' => 'required|array',
            'date-validation' => 'required|date'
        ]);

        DB::table('test_candidate_point')->where('id_test_candidate', $test->id)->delete();
        DB::table('test_candidate_criteria')->where('id_test_candidate', $test->id)->delete();

        foreach($request->input('criteria') as $id => $criterion)
        {
            $pt = new TestCriterionCandidate();
            $pt->id_test_candidate = $test->id;
            $pt->id_criterion = $id;
            $pt->value = $criterion;
            $pt->save();
        }

        foreach($request->input('points') as $id => $point)
        {
            $pt = new TestPointCandidate();
            $pt->id_test_candidate = $test->id;
            $pt->id_point = $id;
            $pt->save();
        }

        $result = DB::table('v_test_candidate_result')->where('id', $test->id)->first();
        $final_mark = ($result->mark + $result->bonus)/$result->coefficient;
        $id_result = ($final_mark < 2.5 || $result->blocant > 0) ? 2: 1;

        $test->date_validated = $request->input('date-validation');
        DB::table('test_candidate')->where('id', $test->id)->update([
            'date_validated' => $request->input('date-validation'),
            'score' => $final_mark,
            'id_result' => $id_result
        ]);

        if($id_result == 1)
        {
            DB::table('cv')->where('id', $test->id_cv_candidate)->update([
                'test' => 'valide'
            ]);
        }

        return redirect($this->url)->with('Test mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        TestCandidate::destroy($id);
        return redirect($this->url)->with('success', 'Réception de Test supprimée avec succès');
    }
}
