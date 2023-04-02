<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BuildLog;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $buildlogs = BuildLog::where('user_id', $user->id);
        

        return view('dashboard', ['buildlogs' => $buildlogs ]);
        //return $dataTable->render('buildlogs.index');
    }
}
