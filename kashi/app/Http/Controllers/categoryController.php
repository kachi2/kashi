<?php

namespace App\Http\Controllers;

use App\category;
use App\sub_category;
use Illuminate\Http\Request;
use App\bill_category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index()
    {
        $category ['category'] = category::All();
        $category['sub'] = sub_category::All();
        return view('admin.category.index', $category);
    }

    public function sub()
    {
        $category ['category'] = category::All();
        $category['sub'] = sub_category::All();
        return view('admin.category.sub-category', $category);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    } 
    
    public function bills_category(){

        return view('admin.category.create_billsCategory');
    }

    public function bills_categories(){
        $category = bill_category::all();
        return view('admin.category.bill_category', compact('category'));
    }
    public function bills_store(Request $request){

        $this->validate($request, [

            'name' => 'required',
            'image'=>'required',
        ]);
            $category = new bill_category;
            $category->name = $request->input('name');
            $category->image('image', $category);
            if($category->save()){

                return redirect()->route('bills.categories')->with('success', 'Bills Category created Successfully');
            }else{
                return redirect()->route('category.index')->with('errors', 'errors');
            }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(isset($request->category_id)){

            $this->validate($request, [

                'name' => 'required',
                'category_id' => 'required',
                'image'=>'required',
            ]);
            $category = new sub_category;
            $category->name = $request->input('name');
            $category->category_id = $request->input('category_id');
            $category->image('image', $category);
            if($category->save()){

                return redirect()->route('category.sub-category')->with('success', 'Sub Category created Successfully');
            }else{
                return redirect()->route('category.sub-category')->with('errors', 'errors');
            }

        }

        $this->validate($request, [

            'name' => 'required',
            'description' => 'required',
            'status'=>'required',
            'image'=>'required',
        ]);
            $category = new category;
            $category->name = $request->input('name');
            $category->description = $request->input('description');
            $category->is_active = $request->input('status');
            $category->image('image', $category);
            if($category->save()){

                return redirect()->route('category.index')->with('success', 'Category created Successfully');
            }else{
                return redirect()->route('category.index')->with('errors', 'errors');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = category::findorfail($id);
        $category['category'] = category::where(['id' => $category->id])->get();
        return view('admin.category.edit', $category);
    }
    public function bill_edit($id)
    {
        $category = bill_category::findorfail($id);
        $category['category'] = bill_category::where(['id' => $category->id])->get();
        return view('admin.category.bill_edit', $category);
    }

    public function edit_sub($id){
            $category = sub_category::findorfail($id);
            $category['category'] = sub_category::where(['id' => $category->id])->get();
            return view('admin.category.edit-sub', $category);
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $validate = $this->validate($request, [

            'name',
            'description',
            'status',
            'image',
            'category_id'
        ]);
        
        if(!$validate){
            
            return redirect()->back();
        }
        
        if(isset($request->category_id)){
            $category = sub_category::findorfail($id);
            $category->name = $request->input('name');
           // $category->is_active = $request->input('status');
            $category->category_id = $request->input('category_id');
            $category->image('image', $category);
            if($category->save()){

                return redirect()->route('category.sub-category')->with('success', 'Sub Category updated Successfully');
            }else{
                return redirect()->route('category.sub-category')->with('errors', 'errors');
            }

        }

            $category = category::findorfail($id);
            $category->name = $request->input('name');
            $category->description = $request->input('description');
            $category->is_active = $request->input('status');
            $category->image('image', $category);
            if($category->save()){

                return redirect()->route('category.index')->with('success', 'Category updated Successfully');
            }else{
                return redirect()->route('category.index')->with('errors', 'errors');
            }
    }

    public function bill_update(Request $request, $id)
    {  
        
         $validate = $this->validate($request, [

            'name',
            'description',
            'status',
            'image',
            'category_id'
        ]);
        
        if(!$validate){
            
            return redirect()->back();
        }
            $category = bill_category::findorfail($id);
            $category->name = $request->input('name');
            $category->image('image', $category);
            if($category->save()){
                return redirect()->route('bills.categories')->with('success', 'bill_Category updated Successfully');
            }else{
                return redirect()->route('category.index')->with('errors', 'errors');
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\category  $category
     * @return \Illuminate\Http\Response
     */

    public function delete($id)
    {
        $sub_cat = sub_category::findorfail($id);
            $sub_cat->delete();
            return redirect()->back()->with('error', 'Sub Category Deleted Successfuly');

    }

    public function Bill_destroy($id)
    {
        $sub_cat = bill_category::findorfail($id);
            $sub_cat->delete();
            return redirect()->back()->with('error', 'bill Category Deleted Successfuly');

    }
    public function destroy($id)
    {
         $category = category::findorfail($id);
        $sub = sub_category::where('category_id', $category->id)->get();
        foreach($sub as $del){
            $del->delete();
        }  
        $category->delete();
        return redirect()->back()->with('error', 'Category Deleted Successfuuly');
    }
}
