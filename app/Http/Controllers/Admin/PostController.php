<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware(['permission:posts.index|posts.create|posts.edit|posts.delete']);
    }
    
    public function index()
    {
        $posts = Post::latest()->when(request()->q, function($posts) {
            $posts = $posts->where('title', 'like', '%'. request()->q .'%');
        })->paginate(10);

        return view('admin.post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::latest()->get();
        $categories = Category::latest()->get();
        return view('admin.post.create', compact('tags','categories'));
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi
        $this->validate($request, [
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2000',
            'title' => 'required|unique:posts',
            'category_id' => 'required',
            'content' => 'required',
        ]);

        // Upload Image
        $image = $request->file('image');
        $image->storeAs('public/posts', $image->hashName());

        // Saving Data
        $post = Post::create([
            'image' => $image->hashName(),
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('title'), '-'),
            'category_id' => $request->input('category_id'),
            'content' => $request->input('content'),
        ]);

        // Assingn Tags
        $post->tags()->attach($request->input('tags'));
        $post->save();

        if($post)
        {
            // redirect dengan pesan sukses
            return redirect()->route('admin.post.index')->with(['success' => 'Data Berhasil Disimpan']);
        }
        else
        {
            return redirect()->route('admin.post.index')->with(['error' => 'Data Gagal Disimpan']);
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
    public function edit(Post $post)
    {
        $tags = Tag::latest()->get();
        $categories = Category::latest()->get();
        return view('admin.post.edit', compact('post','tags','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // Validasi
        $this->validate($request, [
            'title' => 'required|unique:posts,title,'.$post->id,
            'category_id' => 'required',
            'content' => 'required',
        ]);
        
        if($request->file('image') == '')
        {
            $post = Post::findOrFail($post->id);
            $post->update([
                'title' => $request->input('title'),
                'slug' => Str::slug($request->input('title'), '-'),
                'category_id' => $request->input('category_id'),
                'content' => $request->input('content'),
            ]);
        }
        else
        {
            // Remove Old Image
            Storage::disk('local')->delete('public/posts'.$post->image);

            // Upload New Image
            $image = $request->file('image');
            $image->storeAs('public/posts', $image->hashName());

            $post = Post::findOrFail($post->id);
            $post->update([
                'image' => $image->hashName(),
                'title' => $request->input('title'),
                'slug' => Str::slug($request->input('title'), '-'),
                'category_id' => $request->input('category_id'),
                'content' => $request->input('content'),
            ]);
            
        }

        // Assingn Tags
        $post->tags()->sync($request->input('tags'));

        if($post)
        {
            // redirect dengan pesan sukses
            return redirect()->route('admin.post.index')->with(['success' => 'Data Berhasil Diupdate']);
        }
        else
        {
            return redirect()->route('admin.post.index')->with(['error' => 'Data Gagal Diupdate']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $image = Storage::disk('local')->delete('public/posts'.basename($post->image));
        $post->delete();

        if($post)
        {
            return response()->json([
                'status' => 'success'
            ]);
        }
        else
        {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
