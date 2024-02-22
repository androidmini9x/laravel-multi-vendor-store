<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $request = request();

        // $categories = Category::leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
        //     ->select(['categories.*', 'parents.name as parent_name'])
        //     ->filter($request->query())
        //     ->paginate();

        // Using Model
        $categories = Category::with(['parent'])
            // ->select(['categories.*', 'parents.name as parent_name'])
            ->withCount('products as products_number')
            ->filter($request->query())
            ->paginate();
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parents = Category::all();
        $category = new Category();
        return view('dashboard.categories.create', compact('category', 'parents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(Category::roles());

        $request->merge([
            'slug' => Str::slug($request->post('name'))
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('uploads', [
                'disk' => 'public'
            ]);
            $data['image'] = $path;
        }

        $category = Category::create($data);
        return Redirect::route('dashboard.categories.index')->with('success', 'Category created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('dashboard.categories.show', [
            'category' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $parents = Category::where('id', '<>', $id)
                ->where(function($qurey) use($id) {
                    $qurey->whereNull('parent_id')
                        ->orWhere('parent_id', '<>', $id);
                })
                ->get();
        return view('dashboard.categories.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);

        $data = $request->except('image');
        $old_image = $category->image;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('uploads', [
                'disk' => 'public'
            ]);
            $data['image'] = $path;
        }

        if ($old_image && isset($data['image'])) {
            Storage::disk('public')->delete($old_image);
        }

        $category->update($data);
        return redirect()->route('dashboard.categories.index')->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Category::destroy($id);
        $category = Category::findOrFail($id);
        $category->delete();

        // if($category->image) {
        //     Storage::disk('public')->delete($category->image);
        // }

        return redirect()->route('dashboard.categories.index')->with('success', 'Category deleted successfully!');
    }

    public function trash() {
        $categories = Category::onlyTrashed()->paginate();
        return view('dashboard.categories.trash', compact('categories'));
    }

    public function restore($id) {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('dashboard.categories.trash')->with('success', 'Category restored successfully.');
    }

    public function forceDelete($id) {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();

        if($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        return redirect()->route('dashboard.categories.trash')->with('success', 'Category deleted successfully.');
    }
    
}
