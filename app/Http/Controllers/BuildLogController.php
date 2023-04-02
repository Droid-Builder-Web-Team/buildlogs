<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BuildLog;
use Spatie\Tags\Tag;


class BuildLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buildlogs = BuildLog::with('user')->get();
        $types = Tag::getWithType('droidtype');
        $materials = Tag::getWithType('material');

        return view('buildlogs.index', [
            'buildlogs' => $buildlogs, 
            'types' => $types,
            'materials' => $materials 
        ]);
        //return $dataTable->render('buildlogs.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Tag::getWithType('droidtype');
        $materials = Tag::getWithType('material');
        return view('buildlogs.create', [
            'types' => $types,
            'materials' => $materials
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
            'title' => 'required',
            ]
        );

        $buildlog['user_id'] = $request->user()->id;
        $buildlog['title'] = $request['title'];
        $buildlog['description'] = $request['description'];

        try {
            $newbuildlog = BuildLog::create($buildlog);
        } catch (\Illuminate\Database\QueryException $exception) {
            dd($exception);
        }
        $newbuildlog->syncTagsWithType($request['tags'], 'droidtype');

        return redirect()->route('buildlogs.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $buildlog = BuildLog::with('posts')->find($id);

        return view('buildlogs.show', ['buildlog' => $buildlog]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
