<?php
  
namespace App\Http\Controllers\Utilities;
  
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Utilities\CompanySettings;
use App\Models\Utilities\SoaNotes;
use App\Models\References\Departments;
use App\Models\References\AccountTitles;
use App\Models\References\Charges;
use App\Http\Resources\Reference;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;

class ImageUploaderController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */

    public function formSubmit(Request $request)
    {
    	$imageName = time().'.'.$request->file->getClientOriginalExtension();
        $request->file->move(public_path('images'), $imageName);
        
    	return response()->json(['status'=>'success']);
    }
}