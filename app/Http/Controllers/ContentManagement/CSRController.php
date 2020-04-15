<?php

namespace App\Http\Controllers\ContentManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContentManagement\CSR;
use App\Models\Transactions\ContractInfo;
use App\Models\ContentManagement\Gallery;
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
        $csr = CSR::
                    leftJoin('cms_gallery', 'cms_gallery.gallery_id', '=', 'cms_csr.gallery_id')
                    ->where('cms_csr.is_deleted', 0)->orderBy('cms_csr.csr_id', 'desc')->get();

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

        $gallery = new Gallery();
        $csr = new CSR();

        $csr->csr_title = $request->input('csr_title');
        $csr->csr_text = $request->input('csr_text');
        $csr->created_datetime = Carbon::now();
        $csr->created_by = Auth::user()->id;
    
        if($csr->save()){
            $gallery->gallery_type_id = 3; //CSR
            $gallery->ref_id = $csr->csr_id;
            $gallery->gallery_description = $request->input('csr_text');
            $gallery->gallery_file_path = $request->input('gallery_file_path');
            $gallery->save();

            $csr = CSR::findOrFail($csr->csr_id);
            $csr->gallery_id = $gallery->gallery_id;
            $csr->save();
        }
        
        $data = CSR::leftJoin('cms_gallery', 'cms_gallery.gallery_id', '=', 'cms_csr.gallery_id')
                ->findOrFail($csr->csr_id);

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
        $csr = CSR::leftJoin('cms_gallery', 'cms_gallery.gallery_id', '=', 'cms_csr.gallery_id')
                ->findOrFail($id);       
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

        if($csr->update()){
            
            Gallery::where('gallery_type_id',3)->where('ref_id', $id)->delete();

            $gallery = new Gallery;
            $gallery->gallery_type_id = 3; //News and Publication
            $gallery->ref_id = $id;
            $gallery->gallery_description = $request->input('csr_text');
            $gallery->gallery_file_path = $request->input('gallery_file_path');
            $gallery->save();

            $csr = CSR::findOrFail($id);
            $csr->gallery_id = $gallery->gallery_id;
            $csr->save();

        }        
            
        $data = CSR::leftJoin('cms_gallery', 'cms_gallery.gallery_id', '=', 'cms_csr.gallery_id')
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
