<?php

namespace App\Http\Controllers\ContentManagement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ContentManagement\Career;
use App\Models\ContentManagement\Team;
use App\Models\ContentManagement\Carousel;
use App\Models\ContentManagement\Gallery;
use App\Models\Transactions\ContractInfo;
use App\Http\Resources\Reference;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Auth;

class CarouselsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carousels = Carousel::where('cms_carousel.is_deleted', 0)->orderBy('cms_carousel.carousel_id', 'desc')->get();
        return Reference::collection($carousels);
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
                'carousel_desc' => 'required',
                'carousel_image_path' => 'required'
            ]
        )->validate();

        $carousel = new Carousel();

        $carousel->carousel_desc = $request->input('carousel_desc');
        $carousel->carousel_image_path = $request->input('carousel_image_path');
        $carousel->created_datetime = Carbon::now();
        $carousel->created_by = Auth::user()->id;
        $carousel->save();
                
        //return json based from the resource data
        return ( new Reference( $carousel ))
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
        $carousel = Carousel::findOrFail($id);

        return ( new Reference( $carousel ) )
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
        $carousel = Carousel::findOrFail($id);

        Validator::make($request->all(),
            [
                'carousel_desc' => 'required',
                'carousel_image_path' => 'required'
            ]
        )->validate();

        $carousel->carousel_desc = $request->input('carousel_desc');
        $carousel->carousel_image_path = $request->input('carousel_image_path');
        $carousel->modified_datetime = Carbon::now();
        $carousel->modified_by = Auth::user()->id;
        $carousel->update();

        return ( new Reference( $carousel ) )
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
        $carousel = Carousel::findOrFail($id);
        $carousel->is_deleted = 1;
        $carousel->deleted_datetime = Carbon::now();
        $carousel->deleted_by = Auth::user()->id;

        //update classification based on the http json body that is sent
        $carousel->save();

        return ( new Reference( $carousel ) )
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
