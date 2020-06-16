<?php

namespace App\Http\Controllers\Management;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Management\Service;
use App\Models\Management\ServiceItems;
use App\Models\Management\Clients;
use App\Models\Transactions\ContractInfo;
use App\Http\Resources\Reference;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

use DB;
use Auth;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type=1)
    {
        $service = Service::select('*')
                    ->leftJoin('services_type', 'services_type.service_type_id', '=', 'services.service_type_id')
                    ->leftJoin('b_refcategory', 'b_refcategory.category_id', '=', 'services_type.category_id')
                    ->where('services.is_deleted', 0)
                    ->where('services.is_active', $type)
                    ->orderBy('services.service_id', 'desc')->get();
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
                'service_type_id' => 'required|not_in:0'
            ]
        )->validate();

        $service = new Service();
        $service->service_code = $request->input('service_code');
        $service->service_desc = $request->input('service_desc');
        $service->service_note = $request->input('service_note');
        $service->service_type_id = $request->input('service_type_id');
        $service->created_datetime = Carbon::now();
        $service->created_by = Auth::user()->id;

        if($service->save()){
            $service_id = $service->service_id;
            $service_dataSet = [];

            $items = $request->input('service_items');
            foreach($items as $item){
                $service_dataSet[] = [
                    'service_id' => $service_id,
                    'service_group_type_id' => $item['service_group_type_id'],
                    'service_fee' => $item['service_fee']
                ];
            }

            DB::table('service_items')->insert($service_dataSet);

        }

        $data = Service::select('*')
        ->leftJoin('services_type', 'services_type.service_type_id', '=', 'services.service_type_id')
        ->leftJoin('b_refcategory', 'b_refcategory.category_id', '=', 'services_type.category_id')
        ->findOrFail($service->service_id);

        //return json based from the resource data
        return ( new Reference( $data ))
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

    public function serviceitems($id)
    {
        $service_items = ServiceItems::select(
                        'service_items.*',
                        'services_group_type.*'
                    )
                    ->join('services_group_type', 'services_group_type.service_group_type_id', '=', 'service_items.service_group_type_id')
                    ->where('service_items.service_id', $id)->get();

        $services['items'] = Reference::collection($service_items);
        return $services;
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
        Validator::make($request->all(),
            [
                'service_code' => 'required',
                'service_desc' => 'required',
                'service_type_id' => 'required|not_in:0'
            ]
        )->validate();

        $service = Service::findOrFail($request->input('service_id'));
        $service->service_code = $request->input('service_code');
        $service->service_desc = $request->input('service_desc');
        $service->service_note = $request->input('service_note');
        $service->service_type_id = $request->input('service_type_id');
        $service->modified_datetime = Carbon::now();
        $service->modified_by = Auth::user()->id;

        if($service->save()){

            $service_id = $service->service_id;
            $serviceitem_dataSet = [];

            $old_serviceitems = ServiceItems::where('service_id', $service_id);
            $old_serviceitems->delete();

            $items = $request->input('service_items');
            foreach($items as $item){
                $service_dataSet[] = [
                    'service_id' => $service_id,
                    'service_group_type_id' => $item['service_group_type_id'],
                    'service_fee' => $item['service_fee']
                ];
            }

            DB::table('service_items')->insert($service_dataSet);

        }
        
        $data = Service::select('*')
            ->leftJoin('services_type', 'services_type.service_type_id', '=', 'services.service_type_id')
            ->leftJoin('b_refcategory', 'b_refcategory.category_id', '=', 'services_type.category_id')
            ->findOrFail($service_id);

        //return json based from the resource data
        return ( new Reference( $data ))
                ->response()
                ->setStatusCode(201);
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
    
    public function archive($entity,$type,$id)
    {
        $archive = Service::findOrFail($id);
        $archive->is_active = $type;
        $archive->archived_datetime = Carbon::now();
        $archive->archived_by = Auth::user()->id;

        //update classification based on the http json body that is sent
        $archive->save();

        return ( new Reference( $archive ) )
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
        return $exists;
    }
}
