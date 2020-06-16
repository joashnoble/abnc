<?php

namespace App\Http\Controllers\References;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\References\ServiceType;
use App\Models\References\ServiceGroupType;
use App\Models\References\Service;
use App\Models\Transactions\ContractInfo;
use App\Http\Resources\Reference;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Auth;

class ServiceGroupTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $service_group_type = ServiceGroupType::where('is_deleted', 0)->orderBy('service_group_type_id', 'desc')->get();
        return Reference::collection($service_group_type);
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
                'service_group_code' => 'required',
                'service_group_desc' => 'required'
            ]
        )->validate();

        $service_group_type = new ServiceGroupType();
        $service_group_type->service_group_code = $request->input('service_group_code');
        $service_group_type->service_group_desc = $request->input('service_group_desc');
        $service_group_type->created_datetime = Carbon::now();
        $service_group_type->created_by = Auth::user()->id;
    
        $service_group_type->save();

        //return json based from the resource data
        return ( new Reference( $service_group_type ))
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
        $service_group_type = ServiceGroupType::findOrFail($id);

        return ( new Reference( $service_group_type ) )
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
        $service_group_type = ServiceGroupType::findOrFail($id);

        Validator::make($request->all(),
            [
                'service_group_code' => 'required',
                'service_group_desc' => 'required'
            ]
        )->validate();

        
        $service_group_type->service_group_code = $request->input('service_group_code');
        $service_group_type->service_group_desc = $request->input('service_group_desc');
        $service_group_type->modified_datetime = Carbon::now();
        $service_group_type->modified_by = Auth::user()->id;


        //update  based on the http json body that is sent
        $service_group_type->update();

        return ( new Reference( $service_group_type ) )
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
        $service_group_type = ServiceGroupType::findOrFail($id);
        $service_group_type->is_deleted = 1;
        $service_group_type->deleted_datetime = Carbon::now();
        $service_group_type->deleted_by = Auth::user()->id;

        //update classification based on the http json body that is sent
        $service_group_type->save();

        return ( new Reference( $service_group_type ) )
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

        if(Service::where('service_group_type_id', '=', $id)
            ->where('is_deleted', 0)
            ->exists()) {
            $exists = 'true';
        }
        
        return $exists;
    }
}
