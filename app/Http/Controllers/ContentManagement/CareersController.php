<?php

namespace App\Http\Controllers\ContentManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContentManagement\Career;
use App\Models\Transactions\ContractInfo;
use App\Http\Resources\Reference;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Auth;

class CareersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $career = Career::where('is_deleted', 0)->orderBy('career_id', 'desc')->get();
        return Reference::collection($career);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        Validator::make($request->all(),
            [
                'career_title' => 'required',
                'career_description' => 'required'
            ]
        )->validate();

        $career = new Career();
        $career->career_title = $request->input('career_title');
        $career->career_description = $request->input('career_description');
        $career->created_datetime = Carbon::now();
        $career->created_by = Auth::user()->id;
    
        $career->save();

        //return json based from the resource data
        return ( new Reference( $career ))
                ->response()
                ->setStatusCode(201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $career = Career::findOrFail($id);

        return ( new Reference( $career ) )
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $career = Career::findOrFail($id);

        Validator::make($request->all(),
            [
                'career_title' => 'required',
                'career_description' => 'required'
            ]
        )->validate();

        
        $career->career_title = $request->input('career_title');
        $career->career_description = $request->input('career_description');
        $career->modified_datetime = Carbon::now();
        $career->modified_by = Auth::user()->id;


        //update  based on the http json body that is sent
        $career->update();

        return ( new Reference( $career ) )
            ->response()
            ->setStatusCode(200);
    }

    
    /**
     * Update the specified resource in storage for deleting.
     * preventing force delete rather update the is_deleted = true
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $career = Career::findOrFail($id);
        $career->is_deleted = 1;
        $career->deleted_datetime = Carbon::now();
        $career->deleted_by = Auth::user()->id;

        //update classification based on the http json body that is sent
        $career->save();

        return ( new Reference( $career ) )
            ->response()
            ->setStatusCode(200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function checkIfUsed($id)
    {
        $exists = 'false';

        if(ContractInfo::where('category_id', '=', $id)
            ->where('is_deleted', 0)
            ->exists()) {
            $exists = 'true';
        }
        
        return $exists;
    }
}
