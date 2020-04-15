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

class NewsPublicationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $newspublication = NewsPublication::
                    leftJoin('cms_gallery', 'cms_gallery.gallery_id', '=', 'cms_newspublication.gallery_id')
                    ->where('cms_newspublication.is_deleted', 0)->orderBy('cms_newspublication.news_id', 'desc')->get();

        return Reference::collection($newspublication);
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
                'news_description' => 'required',
                'news_publish_date' => 'required'              
            ]
        )->validate();

        $gallery = new Gallery();
        $newspublication = new NewsPublication();

        $newspublication->news_title = $request->input('news_title');
        $newspublication->news_description = $request->input('news_description');
        $newspublication->news_publish_date = date("Y-m-d",strtotime($request->input('news_publish_date')));
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
        
        $data = NewsPublication::leftJoin('cms_gallery', 'cms_gallery.gallery_id', '=', 'cms_newspublication.gallery_id')
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
        $newspublication = NewsPublication::leftJoin('cms_gallery', 'cms_gallery.gallery_id', '=', 'cms_newspublication.gallery_id')
                ->findOrFail($id);

        Validator::make($request->all(),
            [
                'news_title' => 'required',
                'news_description' => 'required',
                'news_publish_date' => 'required' 
            ]
        )->validate();

        
        $newspublication->news_title = $request->input('news_title');
        $newspublication->news_description = $request->input('news_description');
        $newspublication->news_publish_date = date("Y-m-d",strtotime($request->input('news_publish_date')));
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
            
        $data = NewsPublication::leftJoin('cms_gallery', 'cms_gallery.gallery_id', '=', 'cms_newspublication.gallery_id')
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
