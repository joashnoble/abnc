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

class ArchivesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function archive($entity,$type,$id)
    {   
        if ($entity == "service"){
            $archive = Service::findOrFail($id);
        }

        $archive->is_active = intval($type);
        $archive->archived_datetime = Carbon::now();
        $archive->archived_by = Auth::user()->id;

        //update classification based on the http json body that is sent
        $archive->save();

        return ( new Reference( $archive ) )
            ->response()
            ->setStatusCode(200);
    }
}
