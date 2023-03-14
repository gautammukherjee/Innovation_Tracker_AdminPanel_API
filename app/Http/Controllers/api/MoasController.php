<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use App\Models\User;

class MoasController extends Controller
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
        // $this->middleware('auth:api', ['except'=>['login', 'register']]);
    }

    //Get Genes Lists section
    public function getMoasLists(){        
        $sql = "select distinct m.moa_id,m.name as moa_name from news_moa_rels nmr join moas m on nmr.moa_id=m.moa_id where nmr.deleted=0 and m.deleted=0";
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'moasRecords' => $result
        ]);
    }

	//Add MOAs Lists section
    public function addMoas(Request $request){
        $sql = "INSERT INTO testing.moas (name, description) values ('".pg_escape_string($request->name)."', '".pg_escape_string($request->description)."')";
        // echo $sql;
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'moasRecords' => $result
        ]);
    }

    //Add MOAs Lists section
    public function updateMoas(Request $request, $id){

        $sql = "UPDATE testing.moas SET name = '".pg_escape_string($request->name)."', description ='".pg_escape_string($request->description)."' WHERE moa_id=".$id;
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'moasRecords' => $result
        ]);
    }

    //Delete MOAs Lists section
    public function deleteMoas($id){
        $sql = "UPDATE testing.moas SET deleted=1 WHERE moa_id=".$id;
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'moasDeleted' => $result
        ]);
    }
	
    
}
