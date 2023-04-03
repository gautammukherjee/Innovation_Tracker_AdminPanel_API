<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use App\Models\User;

class TaController extends Controller
{
    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function index()
    // {
    //     //
    // }

    public function _construct(){
        $this->middleware('auth:api', ['except'=>['login', 'register']]);
    }

    //Get TA Lists section
    public function getTasLists(){
        $sql = "SELECT ta_id, name, description, created_at FROM testing.tas WHERE deleted=0";
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'tasRecords' => $result
        ]);
    }

    //Get TA Lists section not exist in new_ta_relation table
    public function getTasListsNotExistRl(Request $request, $id){
        $sql = "select n.ta_id, n.name from testing.tas n where n.deleted=0 and not exists (select 1 from testing.news_ta_rels tr where tr.ta_id=n.ta_id and tr.news_id=".$id.")";
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'tasRecords' => $result
        ]);
    }

    //Get TA Lists section exist in new_ta_relation table
    public function getTasListsExistRl(Request $request, $id){
        $sql = "select n.ta_id, n.name from testing.tas n where n.deleted=0 and exists (select 1 from testing.news_ta_rels tr where tr.ta_id=n.ta_id and tr.news_id=".$id.")";
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'tasExistRecords' => $result
        ]);
    }

}
