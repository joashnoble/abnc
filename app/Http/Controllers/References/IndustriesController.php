<?php

namespace App\Http\Controllers\References;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\References\Industry;
use App\Models\References\Service;
use App\Models\Transactions\ContractInfo;
use App\Http\Resources\Reference;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Auth;

class IndustriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $industries = Industry::where('is_deleted', 0)->orderBy('industry_id', 'desc')->get();
        return Reference::collection($industries);
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
                'industry_name' => 'required'
            ]
        )->validate();

        $industry = new Industry();
        $industry->industry_name = $request->input('industry_name');
        $industry->industry_desc = $request->input('industry_desc');
        $industry->created_datetime = Carbon::now();
        $industry->created_by = Auth::user()->id;
    
        $industry->save();

        //return json based from the resource data
        return ( new Reference( $industry ))
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
        $industry = Industry::findOrFail($id);

        return ( new Reference( $industry ) )
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
        $industry = Industry::findOrFail($id);

        Validator::make($request->all(),
            [
                'industry_name' => 'required',
            ]
        )->validate();

        
        $industry->industry_name = $request->input('industry_name');
        $industry->industry_desc = $request->input('industry_desc');
        $industry->modified_datetime = Carbon::now();
        $industry->modified_by = Auth::user()->id;


        //update  based on the http json body that is sent
        $industry->update();

        return ( new Reference( $industry ) )
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
        $industry = Industry::findOrFail($id);
        $industry->is_deleted = 1;
        $industry->deleted_datetime = Carbon::now();
        $industry->deleted_by = Auth::user()->id;

        //update classification based on the http json body that is sent
        $industry->save();

        return ( new Reference( $industry ) )
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

        // if(Service::where('category_id', '=', $id)
        //     ->where('is_deleted', 0)
        //     ->exists()) {
        //     $exists = 'true';
        // }
        
        return $exists;
    }
}
