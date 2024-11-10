<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Menampilkan daftar blog
     */
    public function index()
    {
        $blogs = Blog::latest()->paginate(10);
        return view('manage-blog.index', compact('blogs'));
    }

    /**
     * Menampilkan form untuk membuat blog baru
     */
    public function create()
    {
        return view('manage-blog.create');
    }

    /**
     * Menyimpan blog baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'blog_picture' => 'image|mimes:jpeg,png,jpg|max:2048',
            'blog_link' => 'required|url'
        ]);

        $blog = new Blog();
        $blog->title = $request->title;
        $blog->description = $request->description;
        $blog->blog_link = $request->blog_link;

        if ($request->hasFile('blog_picture')) {
            $image = $request->file('blog_picture');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $blog->blog_picture = $imageName;
        }

        $blog->save();

        return redirect()->route('blog.index')
            ->with('success', 'Blog berhasil dibuat!');
    }

    /**
     * Menampilkan detail blog
     */
    public function show(Blog $blog)
    {
        return view('manage-blog.show', compact('blog'));
    }

    /**
     * Menampilkan form untuk mengedit blog
     */
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('manage-blog.edit', compact('blog'));
    }

    /**
     * Mengupdate blog di database
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'blog_picture' => 'image|mimes:jpeg,png,jpg|max:2048',
            'blog_link' => 'required|url'
        ]);

        $blog->title = $request->title;
        $blog->description = $request->description;
        $blog->blog_link = $request->blog_link;

        if ($request->hasFile('blog_picture')) {
            // Hapus gambar lama jika ada
            if ($blog->blog_picture) {
                unlink(public_path('images/'.$blog->blog_picture));
            }

            $image = $request->file('blog_picture');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $blog->blog_picture = $imageName;
        }

        $blog->save();

        return redirect()->route('blog.index')
            ->with('success', 'Blog berhasil diperbarui!');
    }

    /**
     * Menghapus blog dari database
     */
    public function destroy(Blog $blog)
    {
        if ($blog->blog_picture) {
            unlink(public_path('images/'.$blog->blog_picture));
        }

        $blog->delete();

        return redirect()->route('blog.index')
            ->with('success', 'Blog berhasil dihapus!');
    }
}
