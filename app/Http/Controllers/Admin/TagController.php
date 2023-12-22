<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['permission:tags.index|tags.create|tags.edit|tags.delete']);
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = Tag::latest()->when(request()->q, function($tags) {
            $tags = $tags->where('name', 'like', '%'. request()->q. '%');
        })->paginate(10);

        return view('admin.tag.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tag.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:tags'
        ]);

        $tag = Tag::create([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name'), '-')
        ]);

        if($tag)
        {
            // redirect dengan pesan sukses
            return redirect()->route('admin.tag.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }
        else
        {
            // redirect dengan pesan error
            return redirect()->route('admin.tag.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
         //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        return view('admin.tag.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        $this->validate($request, [
            'name' => 'required|unique:tags,name,'.$tag->id
        ]);

        $tag = Tag::findOrFail($tag->id);
        $tag->update([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name'), '-')
        ]);

        if($tag)
        {
            // redirect dengan pesan sukses
            return redirect()->route('admin.tag.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }
        else
        {
            // redirect dengan pesan error
            return redirect()->route('admin.tag.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        if($tag)
        {
            // response dengan status sukses
            return response()->json([
                'status' => 'success'
            ]);
        }
        else
        {
            // response dengan status error
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
