<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $forms = FormSet::all();
        return view('forms/list', ['forms' => $forms]);
    }

    public function show($slug) {
        if (!$slug) {
            return redirect()->route('formsets');
        }

        $formset = FormSet::where('slug', $slug)->first();

        // dump($formset);exit();

        if(!$formset) {
            flashy()->error('Your Form Doesn`t Exist!');
            return redirect()->route('formsets');
        }

        return view('forms/view', ['formset' => $formset]);
    }

    public function add(Request $request) {
        if($request->method == 'POST') {
            
        }
        $request->session()->put('page', 'forms');
        $request->session()->put('sub_page', 'add');
        return view('forms/add');
    }
}
