<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use App\Models\User;

class NewsletterController extends Controller
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

    public function _construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function getNewsletterLists()
    {
        $sql = "select news_id,user_id,publication_date,title,description,url,deleted from newss n where deleted=0 and not exists (select 1 from newsletter_news where news_id=n.news_id)";
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'newsletterRecords' => $result
        ]);
    }

    //Add Newsletter Lists section
    public function addNewsletter(Request $request)
    {
        $sql = "INSERT INTO newss (user_id, publication_date, title, description, url) values (" . auth()->user()->user_id . ", '" . $request->publication_date . "', '" . pg_escape_string($request->title) . "','" . pg_escape_string($request->description) . "', '" . pg_escape_string($request->url) . "')";
        // echo $sql;
        $result = DB::select(DB::raw($sql));
        $lastId = DB::getPdo()->lastInsertId(); // get the last inserted id

        // insert into news comments
        $sqlc = "INSERT INTO news_comments (news_id, user_id, title, description) values ($lastId, " . auth()->user()->user_id . ", '" . pg_escape_string($request->comments) . "','" . pg_escape_string($request->comments) . "')";
        $resultc = DB::insert(DB::raw($sqlc));
        return response()->json(array('success' => true));
    }

    //Update Newsletter Lists section
    // public function updateNewsletter(Request $request, $id){
    //     // $sql = "UPDATE newss SET user_id = ".auth()->user()->user_id.", publication_date = '".$request->publication_date."', title = '".pg_escape_string($request->title)."', description ='".pg_escape_string($request->description)."', url='".pg_escape_string($request->url)."' WHERE news_id=".$id;
    //     $sql = "UPDATE newss SET user_id = ".auth()->user()->user_id.", title = '".pg_escape_string($request->title)."', description ='".pg_escape_string($request->description)."', url='".pg_escape_string($request->url)."' WHERE news_id=".$id;
    //     //echo $sql;
    //     $result = DB::select(DB::raw($sql));
    //     return response()->json([
    //         'newssRecords' => $result
    //     ]);
    // }

    //Trash Newsletter Lists section
    public function trashNewsletter($id)
    {
        $sql = "UPDATE newss SET deleted=1 WHERE news_id=" . $id;
        $result = DB::select(DB::raw($sql));

        $sqlc = "UPDATE news_comments SET deleted=1 WHERE news_id=" . $id;
        $resultc = DB::select(DB::raw($sqlc));
        return response()->json([
            'newssDeleted' => $resultc
        ]);
    }

    //Permanent Delete Newsletter Lists section
    public function deleteNewsletter($id)
    {
        $sqlc = "delete from news_comments WHERE news_id=" . $id;
        $resultc = DB::select(DB::raw($sqlc));

        $sql = "delete from newss WHERE news_id=" . $id;
        $result = DB::select(DB::raw($sql));

        return response()->json([
            'newssDeleted' => $result
        ]);
    }

    /////////////////////////////// Approval ///////////////////////////////////
    //Approved Newsletter Lists section
    public function approveNewsletter(Request $request)
    {
        // print_r($request->input('news_ids'));
        $approval_date = date('Y-m-d');

        $data = array();
        foreach ($request->input('news_ids') as $innerArray) {
            // $data[] = ['news_id'=>$innerArray, 'user_id'=> auth()->user()->user_id, 'approval_date'=>$approval_date]; 

            $sql = "INSERT INTO newsletter_news (news_id,user_id, approval_date) values ($innerArray, " . auth()->user()->user_id . ", '" . $approval_date . "')";
            $result = DB::insert(DB::raw($sql));

            $sqlc = "INSERT INTO news_comments (news_id, user_id, title, description) values ($innerArray, " . auth()->user()->user_id . ", '" . pg_escape_string($request->comments) . "','" . pg_escape_string($request->comments) . "')";
            $resultc = DB::insert(DB::raw($sqlc));
        }
        return response()->json(array('success' => true));
        // Model::insert($data);
        // DB::table('newsletter_news')->insert($data);
    }

    //Approved Newsletter Lists section
    public function disapproveNewsletter(Request $request)
    {
        $data = array();
        foreach ($request->input('news_ids') as $innerArray) {

            $sql = "UPDATE newss SET deleted=1 WHERE news_id=" . $innerArray;
            $result = DB::insert(DB::raw($sql));

            $sqlc = "INSERT INTO news_comments (news_id, user_id, title, description) values ($innerArray, " . auth()->user()->user_id . ", '" . pg_escape_string($request->comments) . "','" . pg_escape_string($request->comments) . "')";
            $resultc = DB::insert(DB::raw($sqlc));
        }
        return response()->json(array('success' => true));
    }

    //Pending Newsletter Lists section
    public function pendingNewsletter(Request $request, $id)
    {
        $sql = "UPDATE newss SET deleted=0 WHERE news_id=" . $id;
        $result = DB::insert(DB::raw($sql));

        $sqlc = "INSERT INTO news_comments (news_id, user_id, title, description) values ($id, " . auth()->user()->user_id . ", '" . pg_escape_string($request->comments) . "','" . pg_escape_string($request->comments) . "')";
        $resultc = DB::insert(DB::raw($sqlc));
        return response()->json(array('success' => true));
    }

    //Show Comments Newsletter Lists section
    public function getCommentsNewsletter(Request $request, $id)
    {
        $sql = "select n.news_id,n.title,nc.description,u.name from news_comments nc 
        LEFT JOIN newss n ON nc.news_id =  n.news_id
        LEFT JOIN public.users u ON nc.user_id=u.user_id 
        where nc.news_id=" . $id;
        //echo $sql;
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'newsCommentsRecords' => $result
        ]);
    }

    // Get Approve newsletter lists;
    public function getApproveNewsletterLists()
    {
        $sql = "select news_id,user_id,publication_date,title,description,url from newss n where deleted=0 and exists (select 1 from newsletter_news where news_id=n.news_id)";
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'newsletterRecords' => $result
        ]);
    }

    // Get Pending newsletter lists;
    public function getPendingNewsletterLists()
    {
        $sql = "select news_id,user_id,publication_date,title,description,url from newss n where deleted=1";
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'newsletterRecords' => $result
        ]);
    }


    //////////////////// Save all master lists News relations ////////////////////////

    //Save News TA Relation
    public function saveNewsTaRl(Request $request, $id)
    {
        // print_r($request->input('ta_ids'));
        // print_r($request);

        $data = array();
        foreach ($request->input('ta_ids') as $innerArray) {
            // $data[] = ['news_id'=>$innerArray, 'user_id'=> auth()->user()->user_id, 'approval_date'=>$approval_date];
            $sql = "INSERT INTO news_ta_rels (news_id,ta_id) values ($id, " . $innerArray . ")";
            $result = DB::insert(DB::raw($sql));
        }
        return response()->json(array('success' => true));
        // Model::insert($data);
        // DB::table('newsletter_news')->insert($data);
    }

    //Save News Disease Relation
    public function saveNewsDiseaseRl(Request $request, $id)
    {
        // print_r($request->input('ta_ids'));
        // print_r($request);

        $data = array();
        foreach ($request->input('di_ids') as $innerArray) {
            // $data[] = ['news_id'=>$innerArray, 'user_id'=> auth()->user()->user_id, 'approval_date'=>$approval_date];
            $sql = "INSERT INTO news_disease_rels (news_id,disease_id) values ($id, " . $innerArray . ")";
            $result = DB::insert(DB::raw($sql));
        }
        return response()->json(array('success' => true));
        // Model::insert($data);
        // DB::table('newsletter_news')->insert($data);
    }

    //Save News Drug Relation
    public function saveNewsDrugRl(Request $request, $id)
    {
        $data = array();
        foreach ($request->input('drug_ids') as $innerArray) {
            $sql = "INSERT INTO news_drug_rels (news_id,drug_id) values ($id, " . $innerArray . ")";
            $result = DB::insert(DB::raw($sql));
        }
        return response()->json(array('success' => true));
    }

    //Save News Company Relation
    public function saveNewsCompanyRl(Request $request, $id)
    {
        $data = array();
        foreach ($request->input('company_ids') as $innerArray) {
            $sql = "INSERT INTO news_company_rels (news_id,company_id) values ($id, " . $innerArray . ")";
            $result = DB::insert(DB::raw($sql));
        }
        return response()->json(array('success' => true));
    }

    //Save News Gene Relation
    public function saveNewsGeneRl(Request $request, $id)
    {
        $data = array();
        foreach ($request->input('gene_ids') as $innerArray) {
            $sql = "INSERT INTO news_gene_rels (news_id,gene_id) values ($id, " . $innerArray . ")";
            $result = DB::insert(DB::raw($sql));
        }
        return response()->json(array('success' => true));
    }

    //Save News MOA Relation
    public function saveNewsMoaRl(Request $request, $id)
    {
        $data = array();
        foreach ($request->input('moa_ids') as $innerArray) {
            $sql = "INSERT INTO news_moa_rels (news_id,moa_id) values ($id, " . $innerArray . ")";
            $result = DB::insert(DB::raw($sql));
        }
        return response()->json(array('success' => true));
    }

    //1. Save Disease and News Disease Relation
    public function saveUnacuratedDisease(Request $request, $id)
    {
        // $data = array();
        // $sql = "INSERT INTO diseases (name) values ('" . $request->disease_name . "')";
        // echo $sql;
        // //here
        // $result = DB::insert(DB::raw($sql));
        // return response()->json(array('success' => true));

        $sql = "INSERT INTO diseases (name) values ('" . pg_escape_string($request->disease_name) . "')";
        $result = DB::select(DB::raw($sql));
        $lastId = DB::getPdo()->lastInsertId(); // get the last inserted id

        // insert into news disease relations
        $sqlR = "INSERT INTO news_disease_rels (news_id, disease_id, user_id) values ($id, $lastId, " . auth()->user()->user_id . ")";
        $resultR = DB::insert(DB::raw($sqlR));
        // return response()->json(array('success' => true));
        return response()->json([
            'diseaseAdded' => $resultR
        ]);
    }

    //2. Save Drug and News Drug Relation
    public function saveUnacuratedDrug(Request $request, $id)
    {
        $sql = "INSERT INTO drugs (name) values ('" . pg_escape_string($request->drug_name) . "')";
        $result = DB::select(DB::raw($sql));
        $lastId = DB::getPdo()->lastInsertId(); // get the last inserted id

        // insert into news drug relations
        $sqlR = "INSERT INTO news_drug_rels (news_id, drug_id, user_id) values ($id, $lastId, " . auth()->user()->user_id . ")";
        $resultR = DB::insert(DB::raw($sqlR));
        // return response()->json(array('success' => true));
        return response()->json([
            'drugAdded' => $resultR
        ]);
    }

    //3. Save Gene and News Gene Relation
    public function saveUnacuratedGene(Request $request, $id)
    {
        $sql = "INSERT INTO genes (name) values ('" . pg_escape_string($request->gene_name) . "')";
        $result = DB::select(DB::raw($sql));
        $lastId = DB::getPdo()->lastInsertId(); // get the last inserted id

        // insert into news Gene relations
        $sqlR = "INSERT INTO news_gene_rels (news_id, gene_id, user_id) values ($id, $lastId, " . auth()->user()->user_id . ")";
        $resultR = DB::insert(DB::raw($sqlR));
        // return response()->json(array('success' => true));
        return response()->json([
            'geneAdded' => $resultR
        ]);
    }

    //4. Save Company and News company Relation
    public function saveUnacuratedOrg(Request $request, $id)
    {
        $sql = "INSERT INTO companys (company_type_id, name) values (1, '" . pg_escape_string($request->company_name) . "')";
        $result = DB::select(DB::raw($sql));
        $lastId = DB::getPdo()->lastInsertId(); // get the last inserted id

        // insert into news company relations
        $sqlR = "INSERT INTO news_company_rels (news_id, company_id, user_id) values ($id, $lastId, " . auth()->user()->user_id . ")";
        $resultR = DB::insert(DB::raw($sqlR));
        // return response()->json(array('success' => true));
        return response()->json([
            'orgAdded' => $resultR
        ]);
    }

    //5. Save All Entity with News Relation Table
    public function saveAllEntityNewsRelation(Request $request, $id)
    {
        // print_r($request->input('all_entity'));

        ///////////////////// Start Diseases ////////////////////
        if (count($request->input('all_entity')['disease']) > 0) {
            $diseases_ids = array();
            foreach ($request->input('all_entity')['disease'] as $diseases) {
                $diseases_ids[] = $diseases['disease_id'];
            }
            // print_r($diseases_ids);
            $stringDisease = implode(',', $diseases_ids);
            // echo "stringDisease: " . $stringDisease;

            $sql = "SELECT disease_id FROM news_disease_rels where disease_id in ($stringDisease) and news_id = $id and deleted=0";
            $result = DB::select(DB::raw($sql));

            $exists_disease_ids = array();
            if (count($result) > 0) {
                foreach ($result as $value) {
                    $exists_disease_ids[] = $value->disease_id;
                }
            }
            // print_r($exists_disease_ids);

            $filterDiseases = array_diff($diseases_ids, $exists_disease_ids);
            // print_r($filterDiseases);

            //Insert News Diseases Relation table
            if (count($filterDiseases) > 0) {
                foreach ($filterDiseases as $innerArrayDisease) {
                    try {
                        $sql = "INSERT INTO news_disease_rels (news_id,disease_id) values ($id, " . $innerArrayDisease . ")";
                        $result = DB::insert(DB::raw($sql));
                    } catch (\Illuminate\Database\QueryException $ex) {
                        // dd($ex->getMessage());
                        return response()->json([
                            'orgResult' => false
                        ]);
                    }
                }
            }
        }
        ///////////////////// End Diseases ////////////////////

        ///////////////////// Start Drugs ////////////////////
        if (count($request->input('all_entity')['drug']) > 0) {
            $drug_ids = array();
            foreach ($request->input('all_entity')['drug'] as $drugs) {
                $drug_ids[] = $drugs['drug_id'];
            }
            // print_r($drug_ids);
            $stringDrug = implode(',', $drug_ids);

            $sql = "SELECT drug_id FROM news_drug_rels where drug_id in ($stringDrug) and news_id = $id and deleted=0";
            $result = DB::select(DB::raw($sql));

            $exists_drug_ids = array();
            foreach ($result as $value) {
                $exists_drug_ids[] = $value->drug_id;
            }

            $filterDrugs = array_diff($drug_ids, $exists_drug_ids);
            // print_r($filterDrugs);

            //Insert News Drug Relation table
            if (count($filterDrugs) > 0) {
                try {
                    foreach ($filterDrugs as $innerArrayDrug) {
                        $sql = "INSERT INTO news_drug_rels (news_id,drug_id) values ($id, " . $innerArrayDrug . ")";
                        $result = DB::insert(DB::raw($sql));
                    }
                } catch (\Illuminate\Database\QueryException $ex) {
                    // dd($ex->getMessage());
                    return response()->json([
                        'orgResult' => false
                    ]);
                }
            }
        }
        ///////////////////// End Drugs ////////////////////


        ///////////////////// Start Genes ////////////////////
        if (count($request->input('all_entity')['gene']) > 0) {
            $gene_ids = array();
            foreach ($request->input('all_entity')['gene'] as $genes) {
                $gene_ids[] = $genes['gene_id'];
            }
            $stringGene = implode(',', $gene_ids);

            $sql = "SELECT gene_id FROM news_gene_rels where gene_id in ($stringGene) and news_id = $id and deleted=0";
            $result = DB::select(DB::raw($sql));

            $exists_gene_ids = array();
            foreach ($result as $value) {
                $exists_gene_ids[] = $value->gene_id;
            }

            $filterGenes = array_diff($gene_ids, $exists_gene_ids);
            // print_r($filterGenes);

            //Insert News Gene Relation table
            if (count($filterGenes) > 0) {
                try {
                    foreach ($filterGenes as $innerArrayGene) {
                        $sql = "INSERT INTO news_gene_rels (news_id,gene_id) values ($id, " . $innerArrayGene . ")";
                        $result = DB::insert(DB::raw($sql));
                    }
                } catch (\Illuminate\Database\QueryException $ex) {
                    // dd($ex->getMessage());
                    return response()->json([
                        'orgResult' => false
                    ]);
                }
            }
        }
        ///////////////////// End Genes ////////////////////


        ///////////////////// Start Company ////////////////////
        if (count($request->input('all_entity')['organization']) > 0) {
            $company_ids = array();
            foreach ($request->input('all_entity')['organization'] as $organizations) {
                $company_ids[] = $organizations['company_id'];
            }
            $stringCompany = implode(',', $company_ids);

            $sql = "SELECT company_id FROM news_company_rels where company_id in ($stringCompany) and news_id = $id and deleted=0";
            $result = DB::select(DB::raw($sql));

            $exists_company_ids = array();
            foreach ($result as $value) {
                $exists_company_ids[] = $value->company_id;
            }

            $filterCompanies = array_diff($company_ids, $exists_company_ids);
            // print_r($filterCompanies);

            //Insert News Company Relation table
            if (count($filterCompanies) > 0) {
                try {
                    foreach ($filterCompanies as $innerArrayCompany) {
                        $sql = "INSERT INTO news_company_rels (news_id,company_id) values ($id, " . $innerArrayCompany . ")";
                        $result = DB::insert(DB::raw($sql));
                    }
                } catch (\Illuminate\Database\QueryException $ex) {
                    // dd($ex->getMessage());
                    return response()->json([
                        'orgResult' => false
                    ]);
                }
            }
        }
        ///////////////////// End Company ////////////////////
        return response()->json([
            'orgResult' => true
        ]);
    }

    //1. Send data to call api from other resources
    public function get_named_entities_news(Request $request)
    {
	$arrayResponse = array("news_id" => $request->input('news_id'), "news_text" => pg_escape_string($request->input('news_text')));
        return response()->json([
            'newsLetterReturnRecords' => $arrayResponse
        ]);
    }



    /////////////////Backend Completed ///////////////////


    /////////////////////////////////////////// Frontend ///////////////////////////////////

    //////Get Newsletter Lists section
    public function getNewsletterFrontLists(Request $request)
    {
        // $sql = "SELECT ns.news_id, ns.user_id, ns.publication_date, ns.title, ns.description, ns.url, ns.webhose_id, ns.textindex_td, ns.created_at, c.name as user_name FROM newss as ns LEFT JOIN users as c ON ns.user_id=c.user_id WHERE ns.deleted=0";
        // //Publication Date range
        // if($request->from_date!=$request->to_date){
        //     $sql = $sql . " AND publication_date between '". $request->from_date ."' and '".$request->to_date."'";
        // }
        // else {
        //     $sql = $sql . " AND publication_date ='". $request->from_date."'";
        // }

        $sql = "with newsletter as (select nn.news_id,n.user_id,n.publication_date,n.title,n.description,n.url from newsletter_news nn join newss n on nn.news_id=n.news_id WHERE nn.deleted=0 and n.deleted=0 ";

        //1. Publication Date range
        if ($request->from_date != $request->to_date) {
            $sql = $sql . " AND publication_date between '" . $request->from_date . "' and '" . $request->to_date . "'";
        } else {
            $sql = $sql . " AND publication_date ='" . $request->from_date . "'";
        }

        $sql = $sql . " ) select nl.*,b.ta_ids,b.ta_names,c.disease_ids,c.disease_names,d.drug_ids,d.drug_names,e.company_ids,e.company_names,f.gene_ids,f.gene_names,g.marker_ids,g.marker_names,h.moa_ids,h.moa_names from newsletter nl ";
        //$sql = $sql . " ) select nl.* from newsletter nl ";

        //2. Therapeutic area paas
        if ($request->ta_id != "") {
            $taJoin = " Join ";
        } else {
            $taJoin = " Left Join";
        }
        $sql = $sql . $taJoin . " lateral ( select  ntr.news_id,array_agg(ntr.ta_id) ta_ids,array_agg(t.name) as ta_names from news_ta_rels ntr join tas t on ntr.ta_id=t.ta_id where ntr.news_id = nl.news_id and ntr.deleted=0 and t.deleted=0 ";
        if ($request->ta_id != "") {
            $taImplode = implode(", ", $request->ta_id);
            $sql = $sql . " and t.ta_id in (" . $taImplode . ")"; // pass ta_id ids here also replace left join with join when its selected !
        }
        $sql = $sql . " group by ntr.news_id ) as b on true"; //convert left join part to join when any parameter value passed / selected

        //3. Disease indication paas
        if ($request->di_ids != "") {
            $diseaseJoin = " Join ";
        } else {
            $diseaseJoin = " Left Join";
        }
        $sql = $sql . $diseaseJoin . " lateral (select ndr.news_id,array_agg(ndr.disease_id) disease_ids,array_agg(d.name) as disease_names from news_disease_rels ndr join diseases d on ndr.disease_id=d.disease_id where ndr.news_id = nl.news_id and ndr.deleted=0 and d.deleted=0 ";

        if ($request->di_ids != "") {
            $diImplode = implode(",", $request->di_ids);
            $sql = $sql . " and  d.disease_id in (" . $diImplode . ") "; //pass disease_id ids here also replace left join with join when its selected !"
        }
        $sql = $sql . " group by ndr.news_id ) as c on true"; //convert left join part to join when any parameter value passed / selected

        //4. Drug id paas
        if ($request->drug_id != "") {
            $drugJoin = " Join ";
        } else {
            $drugJoin = " Left Join";
        }
        $sql = $sql . $drugJoin . " lateral (select  ndr.news_id,array_agg(ndr.drug_id) as drug_ids,array_agg(d.name) as drug_names from news_drug_rels ndr join drugs d on ndr.drug_id=d.drug_id where ndr.news_id = nl.news_id and ndr.deleted=0 and d.deleted=0 ";
        if ($request->drug_id != "") {
            $drugImplode = implode(",", $request->drug_id);
            $sql = $sql . " and d.drug_id in (" . $drugImplode . ") "; //pass drug_id ids here also replace left join with join when its selected !
        }
        $sql = $sql . " group by ndr.news_id) as d on true"; //convert left join part to join when any parameter value passed / selected

        //5. Company id paas
        if ($request->comp_id != "") {
            $companyJoin = " Join ";
        } else {
            $companyJoin = " Left Join";
        }
        $sql = $sql . $companyJoin . " lateral (select  ncr.news_id,array_agg(ncr.company_id) as company_ids,array_agg(c.name) as company_names from news_company_rels ncr join companys c on ncr.company_id=c.company_id where ncr.news_id = nl.news_id and ncr.deleted=0 and c.deleted=0 ";
        if ($request->comp_id != "") {
            $companyImplode = implode(",", $request->comp_id);
            $sql = $sql . " and ncr.company_id in (" . $companyImplode . ") "; //pass company_id ids here also replace left join with join when its selected !
        }
        $sql = $sql . " group by ncr.news_id) as e on true"; //convert left join part to join when any parameter value passed / selected

        //6. Gene id paas
        if ($request->gene_id != "") {
            $geneJoin = " Join ";
        } else {
            $geneJoin = " Left Join";
        }
        $sql = $sql . $geneJoin . " lateral (select  ngr.news_id,array_agg(ngr.gene_id) as gene_ids,array_agg(g.name) as gene_names from news_gene_rels ngr join genes g on ngr.gene_id=g.gene_id where ngr.news_id = nl.news_id and ngr.deleted=0 and g.deleted=0 ";
        if ($request->gene_id != "") {
            $geneImplode = implode(",", $request->gene_id);
            $sql = $sql . " and  g.gene_id in (" . $geneImplode . ") "; //pass gene_id ids here also replace left join with join when its selected !
        }
        $sql = $sql . " group by ngr.news_id) as f on true"; //convert left join part to join when any parameter value passed / selected

        //7. Marker id paas
        if ($request->marker_id != "") {
            $markerJoin = " Join ";
        } else {
            $markerJoin = " Left Join";
        }
        $sql = $sql . $markerJoin . " lateral (select  nmr.news_id,array_agg(nmr.marker_id) as marker_ids,array_agg(m.name) as marker_names,array_agg(row(nmr.marker_id,m.name)) as marker_details from news_marker_rels nmr join markers m on nmr.marker_id=m.marker_id where nmr.news_id = nl.news_id and nmr.deleted=0 and m.deleted=0 ";
        if ($request->marker_id != "") {
            $markerImplode = implode(",", $request->marker_id);
            $sql = $sql . " and m.marker_id in (" . $markerImplode . ") "; //pass marker_id ids here also replace left join with join when its selected !
        }
        $sql = $sql . " group by nmr.news_id) as g on true"; //convert left join part to join when any parameter value passed / selected

        //8. Moa id paas
        if ($request->moa_id != "") {
            $moaJoin = " Join ";
        } else {
            $moaJoin = " Left Join";
        }
        $sql = $sql . $moaJoin . " lateral (select  nmr.news_id,array_agg(nmr.moa_id) as moa_ids,array_agg(m.name) as moa_names from news_moa_rels nmr join moas m on nmr.moa_id=m.moa_id where nmr.news_id = nl.news_id and nmr.deleted=0 and m.deleted=0 ";
        if ($request->moa_id != "") {
            $moaImplode = implode(",", $request->moa_id);
            $sql = $sql . " and m.moa_id in (" . $moaImplode . ") "; //pass moa_id ids here also replace left join with join when its selected !
        }
        $sql = $sql . " group by nmr.news_id) as h on true"; //convert left join part to join when any parameter value passed / selected
        // echo $sql;

        $result = DB::select(DB::raw($sql));
        return response()->json([
            'newsletterRecords' => $result
        ]);
    }

    public function getNewsletterFrontDetails(Request $request)
    {
        $newsId = $request->news_id;

        // $sql = "SELECT ns.news_id, ns.user_id, ns.publication_date, ns.title, ns.description, ns.url, ns.created_at, c.name as user_name FROM newss as ns LEFT JOIN users as c ON ns.user_id=c.user_id WHERE ns.deleted=0 AND news_id=".$newsId;
        $sql = "with newsletter as (select nn.news_id,n.user_id,n.publication_date,n.title,n.description,n.url from newsletter_news nn join newss n on nn.news_id=n.news_id WHERE nn.deleted=0 and n.deleted=0 ";
        $sql = $sql . " AND n.news_id=" . $newsId;

        $sql = $sql . " ) select nl.*,b.ta_ids,b.ta_names,c.disease_ids,c.disease_names,d.drug_ids,d.drug_names,e.company_ids,e.company_names,f.gene_ids,f.gene_names,g.marker_ids,g.marker_names,h.moa_ids,h.moa_names from newsletter nl ";

        //2. Therapeutic area paas
        if ($request->ta_id != "") {
            $taJoin = " Join ";
        } else {
            $taJoin = " Left Join";
        }
        $sql = $sql . $taJoin . " lateral ( select  ntr.news_id,array_agg(ntr.ta_id) ta_ids,array_agg(t.name) as ta_names from news_ta_rels ntr join tas t on ntr.ta_id=t.ta_id where ntr.news_id = nl.news_id and ntr.deleted=0 and t.deleted=0 ";
        $sql = $sql . " group by ntr.news_id ) as b on true"; //convert left join part to join when any parameter value passed / selected

        //3. Disease indication paas
        if ($request->di_ids != "") {
            $diseaseJoin = " Join ";
        } else {
            $diseaseJoin = " Left Join";
        }
        $sql = $sql . $diseaseJoin . " lateral (select  ndr.news_id,array_agg(ndr.disease_id) disease_ids,array_agg(d.name) as disease_names from news_disease_rels ndr join diseases d on ndr.disease_id=d.disease_id where ndr.news_id = nl.news_id and ndr.deleted=0 and d.deleted=0 ";
        $sql = $sql . " group by ndr.news_id ) as c on true"; //convert left join part to join when any parameter value passed / selected

        //4. Drug id paas
        if ($request->drug_id != "") {
            $drugJoin = " Join ";
        } else {
            $drugJoin = " Left Join";
        }
        $sql = $sql . $drugJoin . " lateral (select  ndr.news_id,array_agg(ndr.drug_id) as drug_ids,array_agg(d.name) as drug_names from news_drug_rels ndr join drugs d on ndr.drug_id=d.drug_id where ndr.news_id = nl.news_id and ndr.deleted=0 and d.deleted=0 ";
        $sql = $sql . " group by ndr.news_id) as d on true"; //convert left join part to join when any parameter value passed / selected

        //5. Company id paas
        if ($request->comp_id != "") {
            $companyJoin = " Join ";
        } else {
            $companyJoin = " Left Join";
        }
        $sql = $sql . $companyJoin . " lateral (select  ncr.news_id,array_agg(ncr.company_id) as company_ids,array_agg(c.name) as company_names from news_company_rels ncr join companys c on ncr.company_id=c.company_id where ncr.news_id = nl.news_id and ncr.deleted=0 and c.deleted=0 ";
        $sql = $sql . " group by ncr.news_id) as e on true"; //convert left join part to join when any parameter value passed / selected

        //6. Gene id paas
        if ($request->gene_id != "") {
            $geneJoin = " Join ";
        } else {
            $geneJoin = " Left Join";
        }
        $sql = $sql . $geneJoin . " lateral (select  ngr.news_id,array_agg(ngr.gene_id) as gene_ids,array_agg(g.name) as gene_names from news_gene_rels ngr join genes g on ngr.gene_id=g.gene_id where ngr.news_id = nl.news_id and ngr.deleted=0 and g.deleted=0 ";
        $sql = $sql . " group by ngr.news_id) as f on true"; //convert left join part to join when any parameter value passed / selected

        //7. Marker id paas
        if ($request->marker_id != "") {
            $markerJoin = " Join ";
        } else {
            $markerJoin = " Left Join";
        }
        $sql = $sql . $markerJoin . " lateral (select  nmr.news_id,array_agg(nmr.marker_id) as marker_ids,array_agg(m.name) as marker_names,array_agg(row(nmr.marker_id,m.name)) as marker_details from news_marker_rels nmr join markers m on nmr.marker_id=m.marker_id where nmr.news_id = nl.news_id and nmr.deleted=0 and m.deleted=0 ";
        $sql = $sql . " group by nmr.news_id) as g on true"; //convert left join part to join when any parameter value passed / selected

        //8. Moa id paas
        if ($request->moa_id != "") {
            $moaJoin = " Join ";
        } else {
            $moaJoin = " Left Join";
        }
        $sql = $sql . $moaJoin . " lateral (select  nmr.news_id,array_agg(nmr.moa_id) as moa_ids,array_agg(m.name) as moa_names from news_moa_rels nmr join moas m on nmr.moa_id=m.moa_id where nmr.news_id = nl.news_id and nmr.deleted=0 and m.deleted=0 ";
        $sql = $sql . " group by nmr.news_id) as h on true"; //convert left join part to join when any parameter value passed / selected
        // echo $sql;

        $result = DB::select(DB::raw($sql));
        return response()->json([
            'newsletterDetails' => $result
        ]);
    }

    // public function getNewsletterDisease(Request $request){
    //     $newsId = $request->news_id;
    //     // echo "news_id: ".$newsId;
    //     $sql = "SELECT ndr.news_id, ndr.disease_id, d.name as disease_name FROM diseases as d LEFT JOIN news_disease_rels as ndr ON d.disease_id=ndr.disease_id WHERE ndr.deleted=0 AND ndr.news_id=".$newsId;
    //     // echo $sql;
    //     $result = DB::select(DB::raw($sql));
    //     return response()->json([
    //         'newsletterDiseaseNames' => $result
    //     ]);
    // }


    public function getNewsletterUserName(Request $request)
    {
        $userId = $request->user_id;
        // echo "userId: ".$userId;
        $sql = "SELECT user_name FROM users WHERE user_id=$userId AND deleted = 0";
        //echo $sql;
        $result = DB::select(DB::raw($sql));
        return response()->json([
            'newsletterUserName' => $result
        ]);
    }

}