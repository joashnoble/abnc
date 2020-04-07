<?php

namespace App\Http\Controllers\ContentManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContentManagement\CSR;
use App\Models\Transactions\ContractInfo;
use App\Http\Resources\Reference;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Auth;

class CSRController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $csr = CSR::where('is_deleted', 0)->orderBy('csr_id', 'desc')->get();
        return Reference::collection($csr);
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
                'csr_title' => 'required',
                'csr_text' => 'required'
            ]
        )->validate();

        $csr = new CSR();
        $csr->csr_title = $request->input('csr_title');
        $csr->csr_text = $request->input('csr_text');
        $csr->created_datetime = Carbon::now();
        $csr->created_by = Auth::user()->id;
    
        $csr->save();

        //return json based from the resource data
        return ( new Reference( $csr ))
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
        $csr = CSR::findOrFail($id);

        return ( new Reference( $csr ) )
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
        $csr = CSR::findOrFail($id);

        Validator::make($request->all(),
            [
                'csr_title' => 'required',
                'csr_text' => 'required'
            ]
        )->validate();

        
        $csr->csr_title = $request->input('csr_title');
        $csr->csr_text = $request->input('csr_text');
        $csr->modified_datetime = Carbon::now();
        $csr->modified_by = Auth::user()->id;


        //update  based on the http json body that is sent
        $csr->update();

        return ( new Reference( $csr ) )
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
        $csr = CSR::findOrFail($id);
        $csr->is_deleted = 1;
        $csr->deleted_datetime = Carbon::now();
        $csr->deleted_by = Auth::user()->id;

        //update classification based on the http json body that is sent
        $csr->save();

        return ( new Reference( $csr ) )
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
