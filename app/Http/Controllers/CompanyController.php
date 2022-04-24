<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use File;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::latest()->paginate(5);
    
        // return view('companies.index',compact('companies'))
        //     ->with('i', (request()->input('page', 1) - 1) * 5);
        return view('companies.index',compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:companies',
            'website' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg|max:2048',
        ]);    
        $imageName = time().'.'.$request->image->extension();  
        $request->merge(['logo' => $imageName]);
        $request->image->move(public_path('logos'), $imageName);
        
        Company::create($request->all()); 
        return redirect()->route('companies.index')
                        ->with('success','Company created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return view('companies.show',compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view('companies.edit',compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:companies',
            'website' => 'required',
            'image' => 'mimes:jpeg,png,jpg|max:2048',
        ]);
        if(!empty($request->image)){
            $imageName = time().'.'.$request->image->extension();  
            $request->merge(['logo' => $imageName]);
            $request->image->move(public_path('logos'), $imageName);
            if(File::exists(public_path('logos/'.$request->logo_img))){
                File::delete(public_path('logos/'.$request->logo_img));
            }
        }
        
        $company->update($request->all());
        return redirect()->route('companies.index')
                        ->with('success','Company updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('companies.index')
                        ->with('success','Company deleted successfully');
    }
}
