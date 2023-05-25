<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use App\Models\User;

class NewsTypeController extends Controller
{

    public function _construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    //Get TA Lists section
    public function getNewsType()
    {
        $sql = "SELECT news_type_id, name FROM news_types WHERE deleted=0";
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'newsTypesRecords' => $result
        ]);
    }

}