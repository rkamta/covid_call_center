<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FormSet;

class FormController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $request->session()->put('page', 'forms');
        $request->session()->put('sub_page', 'list');
        $users = User::where('role', 'operator')->get();
        $forms = FormSet::select('user_id')->get();
        $data = array(
            'users' => $users,
            'forms' => $forms,
        );
        return view('forms/list', $data);
    }

    public function show(Request $request, $uuid) {
        if (!$uuid) {
            return redirect()->route('formsets');
        }

        $formset = FormSet::where('uuid', $uuid)->first();
        
        if(!$formset) {
            flashy()->error('Your Form Doesn`t Exist!');
            return redirect()->route('formsets');
        }

        $user = $formset->user;
        if($request->method == 'POST' || !$user) {
            return redirect()->route('formsets');
        }
        $users = User::select('id', 'name', 'email')->where('role', 'operator')->get();
        $formUsers = [];
        for ($i=0; $i < count($users); $i++) { 
            if($users[$i]->formset) continue;
            array_push($formUsers, $users[$i]);
        }
        $request->session()->put('page', 'forms');
        $request->session()->put('sub_page', 'add');
        $data = array(
            'user_id' => $user ? $user->id : 0,
            'users' => $formUsers
        );

        return view('forms/view', ['data' => $data]);
    }

    public function add(Request $request, $user_id=null) {
        $user = User::where(['id'=> $user_id, 'role' => 'operator'])->first();
        if($request->method == 'POST' || ($user_id && !$user)) {
            return redirect()->route('formsets');
        }
        if($user && $user->formset) {
            return redirect()->route('formset-edit', ['id' => $user->formset->id]);
        }
        $users = User::select('id', 'name', 'email')->where('role', 'operator')->get();
        $formUsers = [];
        for ($i=0; $i < count($users); $i++) { 
            if($users[$i]->formset) continue;
            array_push($formUsers, $users[$i]);
        }
        if(empty($formUsers)) {
            flashy()->error('No available users!');
            return redirect()->route('formsets');
        }
        $request->session()->put('page', 'forms');
        $request->session()->put('sub_page', 'add');
        $data = array(
            'user_id' => $user ? $user->id : 0,
            'users' => $formUsers
        );
        return view('forms/add', ['data' => $data]);
    }

    public function save(Request $request) {
        return json_encode($request->post());
    }

    public function edit(Request $request, $id) {
        if (!$id) {
            return redirect()->route('formsets');
        }

        $formset = FormSet::where('id', $id)->first();
        
        if(!$formset) {
            flashy()->error('Your Form Doesn`t Exist!');
            return redirect()->route('formsets');
        }

        $user = $formset->user;
        if($request->method == 'POST' || !$user) {
            return redirect()->route('formsets');
        }
        $users = User::select('id', 'name', 'email')->where('role', 'operator')->get();
        $formUsers = [];
        for ($i=0; $i < count($users); $i++) { 
            if($users[$i]->formset) continue;
            array_push($formUsers, $users[$i]);
        }
        $request->session()->put('page', 'forms');
        $request->session()->put('sub_page', 'add');
        $data = array(
            'user_id' => $user ? $user->id : 0,
            'users' => $formUsers,
            'formset_id' => $formset->id,
            'items' => $formset->items
        );

        return view('forms/edit', ['data' => $data]);
    }

    public function update(Request $request, $slug) {
        if($request->method == 'POST') {
            
        }
        $request->session()->put('page', 'forms');
        $request->session()->put('sub_page', 'add');
        return view('forms/add');
    }

    public function delete(Request $request, $id) {
        
        $request->session()->put('page', 'forms');
        $request->session()->put('sub_page', 'add');
        return view('forms/add');
    }
}
