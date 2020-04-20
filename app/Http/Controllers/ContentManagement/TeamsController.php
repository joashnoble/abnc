<?php

namespace App\Http\Controllers\ContentManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContentManagement\Career;
use App\Models\ContentManagement\Team;
use App\Models\ContentManagement\Gallery;
use App\Models\Transactions\ContractInfo;
use App\Http\Resources\Reference;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Auth;

class TeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = Team::
                leftJoin('b_refdepartments', 'b_refdepartments.department_id', '=', 'cms_team.department_id')
                ->leftJoin('cms_gallery', 'cms_gallery.gallery_id', '=', 'cms_team.gallery_id')
                ->where('cms_team.is_deleted', 0)->orderBy('cms_team.team_id', 'desc')->get();
        return Reference::collection($teams);
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
                'team_desc' => 'required',
                'department_id' => 'required'
            ]
        )->validate();

        $gallery = new Gallery();
        $team = new Team();

        $team->team_desc = $request->input('team_desc');
        $team->department_id = $request->input('department_id');
        $team->created_datetime = Carbon::now();
        $team->created_by = Auth::user()->id;

        if($team->save()){
            $gallery->gallery_type_id = 5; //Teams
            $gallery->ref_id = $team->team_id;
            $gallery->gallery_description = $request->input('team_desc');
            $gallery->gallery_file_path = $request->input('gallery_file_path');
            $gallery->save();

            $team = Team::findOrFail($team->team_id);
            $team->gallery_id = $gallery->gallery_id;
            $team->save();
        }

        $data = Team::
                leftJoin('b_refdepartments', 'b_refdepartments.department_id', '=', 'cms_team.department_id')
                ->leftJoin('cms_gallery', 'cms_gallery.gallery_id', '=', 'cms_team.gallery_id')
                ->findOrFail($team->team_id);
                
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
        $team = Team::
                leftJoin('b_refdepartments', 'b_refdepartments.department_id', '=', 'cms_team.department_id')
                ->leftJoin('cms_gallery', 'cms_gallery.gallery_id', '=', 'cms_team.gallery_id')
                ->findOrFail($id);

        return ( new Reference( $team ) )
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
        $team = Team::
        leftJoin('b_refdepartments', 'b_refdepartments.department_id', '=', 'cms_team.department_id')
        ->leftJoin('cms_gallery', 'cms_gallery.gallery_id', '=', 'cms_team.gallery_id')
        ->findOrFail($id);

        Validator::make($request->all(),
            [
                'team_desc' => 'required',
                'department_id' => 'required'
            ]
        )->validate();

        $team->team_desc = $request->input('team_desc');
        $team->department_id = $request->input('department_id');
        $team->modified_datetime = Carbon::now();
        $team->modified_by = Auth::user()->id;
        $team->update();


        if($team->update()){

            Gallery::where('gallery_id', $team->gallery_id)->delete();

            $gallery = new Gallery;
            $gallery->gallery_type_id = 5; //Teams
            $gallery->ref_id = $team->team_id;
            $gallery->gallery_description = $request->input('team_desc');
            $gallery->gallery_file_path = $request->input('gallery_file_path');
            $gallery->save();

            $team = Team::findOrFail($team->team_id);
            $team->gallery_id = $gallery->gallery_id;
            $team->save();
        }

        $data = Team::
                leftJoin('b_refdepartments', 'b_refdepartments.department_id', '=', 'cms_team.department_id')
                ->leftJoin('cms_gallery', 'cms_gallery.gallery_id', '=', 'cms_team.gallery_id')
                ->findOrFail($team->team_id);

        return ( new Reference( $data ) )
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
        $team = Team::findOrFail($id);
        $team->is_deleted = 1;
        $team->deleted_datetime = Carbon::now();
        $team->deleted_by = Auth::user()->id;

        //update classification based on the http json body that is sent
        $team->save();

        return ( new Reference( $team ) )
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

        // if(ContractInfo::where('category_id', '=', $id)
        //     ->where('is_deleted', 0)
        //     ->exists()) {
        //     $exists = 'true';
        // }
        
        return $exists;
    }
}
