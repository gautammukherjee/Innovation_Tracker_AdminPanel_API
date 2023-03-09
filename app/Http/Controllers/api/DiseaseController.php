<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use App\Models\User;

class DiseaseController extends Controller
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

    //Get Genes Lists section
    public function getDiseasesLists(){        
        $sql = "SELECT disease_id, name as disease_name FROM testing.diseases WHERE deleted=0";
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'diseasesRecords' => $result
        ]);
    }

    //Add Genes Lists section
    public function addDiseases(Request $request){
        $sql = "INSERT INTO testing.diseases (name, description) values ('".pg_escape_string($request->name)."', '".pg_escape_string($request->description)."')";
        //echo $sql;
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'diseaseRecords' => $result
        ]);
    }

    //Add Genes Lists section
    public function updateDiseases(Request $request, $id){
        $sql = "UPDATE testing.diseases SET name = '".pg_escape_string($request->name)."', description ='".pg_escape_string($request->description)."' WHERE disease_id=".$id;
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'diseaseRecords' => $result
        ]);
    }

    //Delete Genes Lists section
    public function deleteDiseases($id){
        $sql = "UPDATE testing.diseases SET deleted=1 WHERE disease_id=".$id;
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'diseaseDeleted' => $result
        ]);
    }

    //Disease Synonm Lists/add/edit/delete
    
    //Get Disease Synonm Lists section
    public function getDiseaseSynLists(){
        $sql = "SELECT disease_syn_id, disease_id, name, created_at FROM testing.disease_syns WHERE deleted=0";
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'diseasesRecords' => $result
        ]);
    }

    //Add Genes Lists section
    public function addDiseaseSyn(Request $request){
        $sql = "INSERT INTO testing.disease_syns (disease_id,name) values ('".$request->disease_id."', '".pg_escape_string($request->name)."')";
        // echo $sql;
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'diseaseRecords' => $result
        ]);
    }

    //Add Genes Lists section
    public function updateDiseaseSyn(Request $request, $id){
        $sql = "UPDATE testing.disease_syns SET disease_id='".$request->disease_id."', name = '".pg_escape_string($request->name)."' WHERE disease_syn_id=".$id;
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'diseaseRecords' => $result
        ]);
    }

    //Delete Genes Lists section
    public function deleteDiseaseSyn($id){
        $sql = "UPDATE testing.disease_syns SET deleted=1 WHERE disease_syn_id=".$id;
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'diseaseDeleted' => $result
        ]);
    }

}
