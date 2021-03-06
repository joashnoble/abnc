<?php

namespace App\Http\Controllers\ContentManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContentManagement\NewsPublication;
use App\Models\ContentManagement\Gallery;
use App\Models\Transactions\ContractInfo;
use App\Http\Resources\Reference;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

use Auth;
use DB;

class NewsPublicationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($status_id = 'all')
    {
        $newspublication = NewsPublication::select('*',
                    DB::raw('CONCAT_WS("",user.user_lname,", ",user.user_fname,user.user_mname) as publisher'),
                    DB::raw('DATE_FORMAT(news_publish_date, "%M %d, %Y") as news_publish_date'))
                    ->leftJoin('cms_gallery', 'cms_gallery.gallery_id', '=', 'cms_newspublication.gallery_id')
                    ->leftJoin('user_accounts as user', 'user.user_id', '=', 'cms_newspublication.created_by')
                    ->where('cms_newspublication.is_deleted', 0);

                    if($status_id != 'all'){
                        $newspublication->where('cms_newspublication.is_show', $status_id);
                    }

                    $newspublication->orderBy('cms_newspublication.news_id', 'desc');

        return Reference::collection($newspublication->get());
    }

    public function archives($type)
    {
        $newspublication = NewsPublication::select('*',
                    DB::raw('CONCAT_WS("",user.user_lname,", ",user.user_fname,user.user_mname) as publisher'),
                    DB::raw('DATE_FORMAT(news_publish_date, "%M %d, %Y") as news_publish_date'))
                    ->leftJoin('cms_gallery', 'cms_gallery.gallery_id', '=', 'cms_newspublication.gallery_id')
                    ->leftJoin('user_accounts as user', 'user.user_id', '=', 'cms_newspublication.created_by')
                    ->where('cms_newspublication.is_deleted', 0)
                    ->where('cms_newspublication.is_active', $type)
                    ->orderBy('cms_newspublication.news_id', 'desc');

        return Reference::collection($newspublication->get());
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
                'news_title' => 'required',
                'news_publish_date' => 'required',
                'news_description' => 'required'              
            ]
        )->validate();

        $gallery = new Gallery();
        $newspublication = new NewsPublication();

        $newspublication->news_title = $request->input('news_title');
        $newspublication->news_description = $request->input('news_description');
        $newspublication->news_publish_date = date("Y-m-d",strtotime($request->input('news_publish_date')));
        $newspublication->sort_id = $request->input('sort_id');
        $newspublication->created_datetime = Carbon::now();
        $newspublication->created_by = Auth::user()->id;

        if($newspublication->save()){
            $gallery->gallery_type_id = 1; //News and Publication
            $gallery->ref_id = $newspublication->news_id;
            $gallery->gallery_description = $request->input('news_description');
            $gallery->gallery_file_path = $request->input('gallery_file_path');
            $gallery->save();

            $newspublication = NewsPublication::findOrFail($newspublication->news_id);
            $newspublication->gallery_id = $gallery->gallery_id;
            $newspublication->save();
        }

        $data = NewsPublication::select('*',
                    DB::raw('CONCAT_WS("",user.user_lname,", ",user.user_fname,user.user_mname) as publisher'),
                    DB::raw('DATE_FORMAT(news_publish_date, "%M %d, %Y") as news_publish_date'))
                    ->leftJoin('cms_gallery', 'cms_gallery.gallery_id', '=', 'cms_newspublication.gallery_id')
                    ->leftJoin('user_accounts as user', 'user.user_id', '=', 'cms_newspublication.created_by')
                    ->findOrFail($newspublication->news_id);

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
        $newspublication = NewsPublication::leftJoin('cms_gallery', 'cms_gallery.gallery_id', '=', 'cms_newspublication.gallery_id')
                ->findOrFail($id);        

        return ( new Reference( $newspublication ) )
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
        $newspublication = NewsPublication::findOrFail($id);

        Validator::make($request->all(),
            [
                'news_title' => 'required',
                'news_publish_date' => 'required',
                'news_description' => 'required' 
            ]
        )->validate();

        
        $newspublication->news_title = $request->input('news_title');
        $newspublication->news_description = $request->input('news_description');
        $newspublication->news_publish_date = date("Y-m-d",strtotime($request->input('news_publish_date')));
        $newspublication->sort_id = $request->input('sort_id');
        $newspublication->modified_datetime = Carbon::now();
        $newspublication->modified_by = Auth::user()->id;

        if($newspublication->update()){
            
            Gallery::where('gallery_type_id',1)->where('ref_id', $id)->delete();

            $gallery = new Gallery;
            $gallery->gallery_type_id = 1; //News and Publication
            $gallery->ref_id = $id;
            $gallery->gallery_description = $request->input('news_description');
            $gallery->gallery_file_path = $request->input('gallery_file_path');
            $gallery->save();

            $newspublication = NewsPublication::findOrFail($id);
            $newspublication->gallery_id = $gallery->gallery_id;
            $newspublication->save();

        }        
        
        $data = NewsPublication::select('*',
                    DB::raw('CONCAT_WS("",user.user_lname,", ",user.user_fname,user.user_mname) as publisher'),
                    DB::raw('DATE_FORMAT(news_publish_date, "%M %d, %Y") as news_publish_date'))
                    ->leftJoin('cms_gallery', 'cms_gallery.gallery_id', '=', 'cms_newspublication.gallery_id')
                    ->leftJoin('user_accounts as user', 'user.user_id', '=', 'cms_newspublication.created_by')
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
        $newspublication = NewsPublication::findOrFail($id);
        $newspublication->is_deleted = 1;
        $newspublication->deleted_datetime = Carbon::now();
        $newspublication->deleted_by = Auth::user()->id;

        //update classification based on the http json body that is sent
        $newspublication->save();

        return ( new Reference( $newspublication ) )
            ->response()
            ->setStatusCode(200);
    }

    public function activate($type,$id)
    {   
        $status = NewsPublication::findOrFail($id);
        $status->is_show = intval($type);

        //update classification based on the http json body that is sent
        $status->save();
        
        $data = NewsPublication::select('*',
                    DB::raw('CONCAT_WS("",user.user_lname,", ",user.user_fname,user.user_mname) as publisher'),
                    DB::raw('DATE_FORMAT(news_publish_date, "%M %d, %Y") as news_publish_date'))
                    ->leftJoin('cms_gallery', 'cms_gallery.gallery_id', '=', 'cms_newspublication.gallery_id')
                    ->leftJoin('user_accounts as user', 'user.user_id', '=', 'cms_newspublication.created_by')
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

    public function archive($type)
    {
        $archive = NewsPublication::findOrFail($id);
        $archive->is_active = $type;
        $archive->archived_datetime = Carbon::now();
        $archive->archived_by = Auth::user()->id;

        //update classification based on the http json body that is sent
        $archive->save();

        return ( new Reference( $archive ) )
            ->response()
            ->setStatusCode(200);
    }
}
