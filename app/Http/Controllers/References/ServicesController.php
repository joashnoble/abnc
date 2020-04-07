<?php

namespace App\Http\Controllers\References;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\References\Service;
use App\Models\Transactions\ContractInfo;
use App\Http\Resources\Reference;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Auth;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $service = Service::leftJoin('b_refcategory', 'b_refcategory.category_id', '=', 'services.category_id')
        ->leftJoin('services_type', 'services_type.service_type_id', '=', 'services.service_type_id')
                    ->where('services.is_deleted', 0)->orderBy('services.service_id', 'desc')->get();
        return Reference::collection($service);

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
                'service_code' => 'required',
                'service_desc' => 'required',
                'service_amount' => 'required'

            ]
        )->validate();

        $service = new Service();
        $service->service_code = $request->input('service_code');
        $service->service_desc = $request->input('service_desc');
        $service->category_id = $request->input('category_id');
        $service->service_type_id = $request->input('service_type_id');
        $service->service_amount = $request->input('service_amount');
        $service->created_datetime = Carbon::now();
        $service->created_by = Auth::user()->id;
        $service->save();

        //return json based from the resource data
        return ( new Reference( $service ))
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
        $service = Service::findOrFail($id);

        return ( new Reference( $service ) )
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
        $service = Service::findOrFail($id);

        Validator::make($request->all(),
            [
                'service_code' => 'required',
                'service_desc' => 'required',
                'service_amount' => 'required'
            ]
        )->validate();

        
        $service->service_code = $request->input('service_code');
        $service->service_desc = $request->input('service_desc');
        $service->category_id = $request->input('category_id');
        $service->service_type_id = $request->input('service_type_id');
        $service->service_amount = $request->input('service_amount');
        $service->modified_datetime = Carbon::now();
        $service->modified_by = Auth::user()->id;


        //update  based on the http json body that is sent
        $service->update();

        return ( new Reference( $service ) )
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
        $service = Service::findOrFail($id);
        $service->is_deleted = 1;
        $service->deleted_datetime = Carbon::now();
        $service->deleted_by = Auth::user()->id;

        //update classification based on the http json body that is sent
        $service->save();

        return ( new Reference( $service ) )
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
