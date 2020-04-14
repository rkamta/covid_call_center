<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\State;
use App\Models\User;

class AjaxController extends Controller
{
    public function __construct()
    {
        $this->extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $this->middleware(['auth']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function avatar_upload(Request $request)
    {
        $file_extension = $request->imgFile->extension();
        if($this->validate_extension($file_extension)) {
            try {
                $file_name = Str::orderedUuid() . '.' . $file_extension;
                $request->imgFile->move(public_path('/uploads'), $file_name);
                return response()->json(['result'=> 1, 'file_name'=> url('/uploads') . '/' . $file_name]);
            } catch ( Throwable $e ) {
                return response()->json(['result'=> 0]);
            }
        }else {
            return response()->json(['result'=> -1]);
        }
        // var_dump($request->file()->);
    }

    public function get_districts(Request $request)
    {
        $province_id = intval($request->post('province_id'));
        $state = State::find($province_id);
        $districts = $state->districts;
        return response()->json($districts);
    }

    public function validate_extension($extension) 
    {
        return in_array($extension, $this->extensions);
    }

}
