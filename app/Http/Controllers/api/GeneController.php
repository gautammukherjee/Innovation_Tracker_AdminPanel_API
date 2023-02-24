<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use App\Models\User;

class GeneController extends Controller
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
    public function getGenesLists(){        
        $sql = "SELECT * FROM testing.genes WHERE deleted=0";
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'genesRecords' => $result
        ]);
    }


    //Add Genes Lists section
    public function addGenes(Request $request){
        $sql = "INSERT INTO testing.genes (name, symbol) values ('".$request->name."', '".$request->symbol."')";
        // echo $sql;
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'genesRecords' => $result
        ]);
    }

    //Add Genes Lists section
    public function updateGenes(Request $request, $id){
        $sql = "UPDATE testing.genes SET name = '".$request->name."', symbol ='".$request->symbol."' WHERE gene_id=".$id;
        // echo $sql;
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'genesRecords' => $result
        ]);
    }

    //Delete Genes Lists section
    public function deleteGenes($id){
        $sql = "DELETE FROM testing.genes WHERE gene_id=".$id;
        //echo $sql;
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'genesDeleted' => $result
        ]);
    }
}
