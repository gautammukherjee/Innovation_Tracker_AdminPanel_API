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
        $sql = "SELECT gene_id, name as gene_name, symbol, description, created_at FROM testing.genes WHERE deleted=0";
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'genesRecords' => $result
        ]);
    }

    //Add Genes Lists section
    public function addGenes(Request $request){
        $sql = "INSERT INTO testing.genes (name, symbol, description) values ('".pg_escape_string($request->name)."', '".pg_escape_string($request->symbol)."', '".pg_escape_string($request->description)."')";
        // echo $sql;
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'genesRecords' => $result
        ]);
    }

    //Add Genes Lists section
    public function updateGenes(Request $request, $id){
        $sql = "UPDATE testing.genes SET name = '".pg_escape_string($request->name)."', symbol ='".pg_escape_string($request->symbol)."', description ='".pg_escape_string($request->description)."' WHERE gene_id=".$id;
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'genesRecords' => $result
        ]);
    }

    //Delete Genes Lists section
    public function deleteGenes($id){
        $sql = "UPDATE testing.genes SET deleted=1 WHERE gene_id=".$id;
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'genesDeleted' => $result
        ]);
    }

    //Gene Synonm Lists/add/edit/delete
    
    //Get Gene Synonm Lists section
    public function getGeneSynLists(){
        $sql = "SELECT gene_syn_id, gene_id, name, created_at FROM testing.gene_syns WHERE deleted=0";
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'genesRecords' => $result
        ]);
    }

    //Add Genes Lists section
    public function addGeneSyn(Request $request){
        $sql = "INSERT INTO testing.gene_syns (gene_id,name) values ('".$request->gene_id."', '".pg_escape_string($request->name)."')";
        // echo $sql;
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'genesRecords' => $result
        ]);
    }

    //Add Genes Lists section
    public function updateGeneSyn(Request $request, $id){
        $sql = "UPDATE testing.gene_syns SET gene_id='".$request->gene_id."', name = '".pg_escape_string($request->name)."' WHERE gene_syn_id=".$id;
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'genesRecords' => $result
        ]);
    }

    //Delete Genes Lists section
    public function deleteGeneSyn($id){
        $sql = "UPDATE testing.gene_syns SET deleted=1 WHERE gene_syn_id=".$id;
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'geneDeleted' => $result
        ]);
    }
}
