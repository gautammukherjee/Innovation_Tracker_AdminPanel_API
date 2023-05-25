<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use App\Models\User;

class DevelopmentPhaseController extends Controller
{
    public function _construct()
    {
        // $this->middleware('auth:api', ['except'=>['login', 'register']]);
    }

    //Get Genes Lists section
    public function getDevelopmentPhaseLists()
    {
        $sql = "select distinct d.dev_phase_id,d.name as dev_phase_name, d.description, d.created_at from  dev_phases d where d.deleted=0";
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'developmentRecords' => $result
        ]);
    }


}