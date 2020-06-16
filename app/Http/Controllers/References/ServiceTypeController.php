<?php

namespace App\Http\Controllers\References;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\References\ServiceType;
use App\Models\References\Service;
use App\Models\References\ServiceSelectType;
use App\Models\Transactions\ContractInfo;
use App\Http\Resources\Reference;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Auth;

class ServiceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $service_type = ServiceType::leftJoin('b_refcategory', 'b_refcategory.category_id', '=', 'services_type.category_id')
        ->leftJoin('services_select_type', 'services_select_type.select_type_id', '=', 'services_type.select_type_id')    
        ->where('services_type.is_deleted', 0)->orderBy('services_type.service_type_id', 'desc')->get();
        return Reference::collection($service_type);
    }

    public function selecttypelist(){
        $select_type = ServiceSelectType::orderBy('select_type_id', 'desc')->get();
        return Reference::collection($select_type);
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
                'service_type_code' => 'required',
                'service_type_desc' => 'required',
                'select_type_id' => 'required|not_in:0',
                'category_id' => 'required|not_in:0'
            ]
        )->validate();

        $service_type = new ServiceType();
        $service_type->service_type_code = $request->input('service_type_code');
        $service_type->service_type_desc = $request->input('service_type_desc');
        $service_type->category_id = $request->input('category_id');
        $service_type->select_type_id = $request->input('select_type_id');
        $service_type->created_datetime = Carbon::now();
        $service_type->created_by = Auth::user()->id;
    
        $service_type->save();

        $service_type = ServiceType::leftJoin('b_refcategory', 'b_refcategory.category_id', '=', 'services_type.category_id')
            ->leftJoin('services_select_type', 'services_select_type.select_type_id', '=', 'services_type.select_type_id')        
            ->findOrFail($service_type->service_type_id);

        //return json based from the resource data
        return ( new Reference( $service_type ))
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
        $service_type = ServiceType::findOrFail($id);

        return ( new Reference( $service_type ) )
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
        $service_type = ServiceType::findOrFail($id);

        Validator::make($request->all(),
            [
                'service_type_code' => 'required',
                'service_type_desc' => 'required',
                'select_type_id' => 'required|not_in:0',
                'category_id' => 'required|not_in:0'
            ]
        )->validate();

        
        $service_type->service_type_code = $request->input('service_type_code');
        $service_type->service_type_desc = $request->input('service_type_desc');
        $service_type->category_id = $request->input('category_id');
        $service_type->select_type_id = $request->input('select_type_id');
        $service_type->modified_datetime = Carbon::now();
        $service_type->modified_by = Auth::user()->id;

        //update  based on the http json body that is sent
        $service_type->update();
        
        $service_type = ServiceType::leftJoin('b_refcategory', 'b_refcategory.category_id', '=', 'services_type.category_id')
            ->leftJoin('services_select_type', 'services_select_type.select_type_id', '=', 'services_type.select_type_id')        
            ->findOrFail($id);

        return ( new Reference( $service_type ) )
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
        $service_type = ServiceType::findOrFail($id);
        $service_type->is_deleted = 1;
        $service_type->deleted_datetime = Carbon::now();
        $service_type->deleted_by = Auth::user()->id;

        //update classification based on the http json body that is sent
        $service_type->save();

        return ( new Reference( $service_type ) )
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

        if(Service::where('service_type_id', '=', $id)
            ->where('is_deleted', 0)
            ->exists()) {
            $exists = 'true';
        }
        
        return $exists;
    }
}
