<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use App\Models\State;
use App\Models\District;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $request->session()->put('page', 'profile');
        $user = $request->user();
        if($user->profile) {
            $state = $user->profile->state;
            $district = $user->profile->district;
            $profile = array(
                'avatar' => $user->profile->avatar,
                'province' => $state ? array('id' => $state->id, 'name' => $state->name) : new \ArrayObject(),
                'district' => $district ? array(
                    'id' => $district->id, 
                    'name' => $district->name, 
                    'state_id' => $district->state_id 
                ) : new \ArrayObject(),
            );
        }else {
            $profile = array(
                'avatar' => '',
                'province' => new \ArrayObject(),
                'district' => new \ArrayObject(),
            );
        }

        $districts = array();
        if($user->profile && !empty($user->profile->state->districts)) {
            $districts = $user->profile->state->districts;
        }
        
        $data = array(
            'user' => array(
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ),
            'profile' => $profile,
            'provinces' => State::all(['id', 'name']),
            'districts_of_user_province' => $districts,
        );
        return view('profile')->with('data', $data);
    }

    public function update(Request $request) {
        $profile = $request->user()->profile;
        $user = User::where('id', $request->user()->id)->first();
        if(is_null($profile)) {
            $profile = new Profile;
        }
        $form = $request->post('form');
        if($form === 'fst') {
            $user_name = $request->post('name');
            $user_email = $request->post('email');
            $avatar = $request->post('avatar_url');
            $state_id = $request->post('province');
            $district_id = $request->post('district');
            
            if($user->name !== $user_name) {
                $user->name = $user_name;
            }
            if($user->email !== $user_email) {
                $user->email = $user_email;
            }
            $user->save();

            $profile->user_id = $user->id;
            $profile->avatar = $avatar;
            $profile->state_id = $state_id > 0 ? $state_id : null;
            $profile->district_id = $district_id ? $district_id : null;
            $profile->save();
            
        } else if ($form === 'snd') {

        }

        return redirect()->route('profile');
    }
}
