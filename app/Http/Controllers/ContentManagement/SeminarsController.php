<?php

namespace App\Http\Controllers\ContentManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContentManagement\Seminar;
use App\Models\Transactions\ContractInfo;
use App\Models\ContentManagement\Gallery;
use App\Http\Resources\Reference;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

use Auth;
use DB;

class SeminarsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($status_id = 'all')
    {
        $seminar = Seminar::select('*',
            DB::raw('DATE_FORMAT(cms_seminars.seminar_date, "%M %d, %Y") as seminar_date'))
            ->leftJoin('cms_gallery', 'cms_gallery.gallery_id', '=', 'cms_seminars.gallery_id')
            ->where('cms_seminars.is_deleted', 0);

            if($status_id != 'all'){
                $seminar->where('cms_seminars.is_show', $status_id);
            }

            $seminar->orderBy('cms_seminars.seminar_id', 'desc');

        return Reference::collection($seminar->get());
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
                'seminar_title' => 'required',
                'seminar_description' => 'required',
                'speaker_fullname' => 'required',
                'seminar_venue' => 'required',
                'seminar_date' => 'required',
                'seminar_time_from' => 'required',
                'seminar_time_to' => 'required'
            ]
        )->validate();

        $gallery = new Gallery();
        $seminar = new Seminar();

        $seminar->seminar_title = $request->input('seminar_title');
        $seminar->seminar_description = $request->input('seminar_description');
        $seminar->speaker_fullname = $request->input('speaker_fullname');
        $seminar->speaker_position = $request->input('speaker_position');
        $seminar->seminar_date = date("Y-m-d",strtotime($request->input('seminar_date')));
        $seminar->seminar_time_from = date("H:i:s",strtotime($request->input('seminar_time_from')));
        $seminar->seminar_time_to = date("H:i:s",strtotime($request->input('seminar_time_to')));
        $seminar->seminar_venue = $request->input('seminar_venue');
        $seminar->sort_id = $request->input('sort_id');
        $seminar->created_datetime = Carbon::now();
        $seminar->created_by = Auth::user()->id;
    
        if($seminar->save()){
            $gallery->gallery_type_id = 2; //Seminars
            $gallery->ref_id = $seminar->seminar_id;
            $gallery->gallery_description = $request->input('seminar_description');
            $gallery->gallery_file_path = $request->input('gallery_file_path');
            $gallery->save();

            $seminar = Seminar::findOrFail($seminar->seminar_id);
            $seminar->gallery_id = $gallery->gallery_id;
            $seminar->save();
        }

        $data = Seminar::select('*',
                    DB::raw('DATE_FORMAT(seminar_date, "%M %d, %Y") as seminar_date'))
                    ->leftJoin('cms_gallery', 'cms_gallery.gallery_id', '=', 'cms_seminars.gallery_id')
                    ->findOrFail($seminar->seminar_id);

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $seminar = Seminar::leftJoin('cms_gallery', 'cms_gallery.gallery_id', '=', 'cms_seminars.gallery_id')
                ->findOrFail($id);   

        return ( new Reference( $seminar ) )
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
        $seminar = Seminar::leftJoin('cms_gallery', 'cms_gallery.gallery_id', '=', 'cms_seminars.gallery_id')
                    ->findOrFail($id);

        Validator::make($request->all(),
            [
                'seminar_title' => 'required',
                'seminar_description' => 'required',
                'speaker_fullname' => 'required',
                'seminar_venue' => 'required',
                'seminar_date' => 'required',
                'seminar_time_from' => 'required',
                'seminar_time_to' => 'required'
            ]
        )->validate();

        
        $seminar->seminar_title = $request->input('seminar_title');
        $seminar->seminar_description = $request->input('seminar_description');
        $seminar->speaker_fullname = $request->input('speaker_fullname');
        $seminar->speaker_position = $request->input('speaker_position');
        $seminar->seminar_date = date("Y-m-d",strtotime($request->input('seminar_date')));
        $seminar->seminar_time_from = date("H:i:s",strtotime($request->input('seminar_time_from')));
        $seminar->seminar_time_to = date("H:i:s",strtotime($request->input('seminar_time_to')));
        $seminar->seminar_venue = $request->input('seminar_venue');     
        $seminar->sort_id = $request->input('sort_id');   
        $seminar->modified_datetime = Carbon::now();
        $seminar->modified_by = Auth::user()->id;

        if($seminar->update()){
            
            Gallery::where('gallery_type_id',2)->where('ref_id', $id)->delete();

            $gallery = new Gallery;
            $gallery->gallery_type_id = 2; //Seminars
            $gallery->ref_id = $seminar->seminar_id;
            $gallery->gallery_description = $request->input('seminar_description');
            $gallery->gallery_file_path = $request->input('gallery_file_path');
            $gallery->save();

            $seminar = Seminar::findOrFail($seminar->seminar_id);
            $seminar->gallery_id = $gallery->gallery_id;
            $seminar->save();
        }
        
        $data = Seminar::select('*',
            DB::raw('DATE_FORMAT(seminar_date, "%M %d, %Y") as seminar_date'))
            ->leftJoin('cms_gallery', 'cms_gallery.gallery_id', '=', 'cms_seminars.gallery_id')
            ->findOrFail($id);

        //return json based from the resource data
        return ( new Reference( $data ))
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
        $seminar = Seminar::findOrFail($id);
        $seminar->is_deleted = 1;
        $seminar->deleted_datetime = Carbon::now();
        $seminar->deleted_by = Auth::user()->id;

        //update classification based on the http json body that is sent
        $seminar->save();

        return ( new Reference( $seminar ) )
            ->response()
            ->setStatusCode(200);
    }

    public function activate($type,$id)
    {   
        $status = Seminar::findOrFail($id);
        $status->is_show = intval($type);

        //update classification based on the http json body that is sent
        $status->save();
        
        $data = Seminar::select('*',
                    DB::raw('DATE_FORMAT(seminar_date, "%M %d, %Y") as seminar_date'))
                    ->leftJoin('cms_gallery', 'cms_gallery.gallery_id', '=', 'cms_seminars.gallery_id')
                    ->findOrFail($id);

        return ( new Reference( $data ) )
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
