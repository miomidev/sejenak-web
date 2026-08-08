<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    // Admin - List semua blog
    public function index()
    {
        $posts = BlogPost::with(['category', 'author', 'tags'])
            ->latest()
            ->paginate(12);
            
        return view('admin.blog.index', compact('posts'));
    }

    // Admin - Form create blog
    public function create()
    {
        $categories = BlogCategory::all();
        $tags = BlogTag::all();
        return view('admin.blog.create', compact('categories', 'tags'));
    }

    // Admin - Store blog
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:blog_categories,id',
            'featured_image' => 'nullable|image|max:2048',
            'excerpt' => 'nullable|max:500',
            'tags' => 'nullable|array',
            'is_published' => 'boolean'
        ]);

        $post = new BlogPost();
        $post->title = $request->title;
        $post->slug = Str::slug($request->title) . '-' . time();
        $post->content = $request->content ?? '<p>Konten blog...</p>'; // Default content fallback
        $post->excerpt = $request->excerpt;
        $post->category_id = $request->category_id;
        $post->user_id = auth()->id();
        $post->is_published = $request->is_published ?? false;
        $post->published_at = $request->is_published ? now() : null;
        $post->reading_time = $post->getReadingTimeAttribute();

        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('blog-images', 'public');
            $post->featured_image = $path;
        }

        $post->save();

        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        }

        return redirect()->route('admin.blog.index')->with('success', 'Blog post berhasil dibuat!');
    }

    // Admin - Edit blog
    public function edit(BlogPost $blog)
    {
        $categories = BlogCategory::all();
        $tags = BlogTag::all();
        return view('admin.blog.edit', compact('blog', 'categories', 'tags'));
    }

    // Admin - Update blog
    public function update(Request $request, BlogPost $blog)
    {
        $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:blog_categories,id',
            'featured_image' => 'nullable|image|max:2048',
            'excerpt' => 'nullable|max:500',
            'tags' => 'nullable|array',
            'is_published' => 'boolean'
        ]);

        $blog->title = $request->title;
        $blog->content = $request->content ?? $blog->content;
        $blog->excerpt = $request->excerpt;
        $blog->category_id = $request->category_id;
        $blog->is_published = $request->is_published ?? false;
        $blog->published_at = $request->is_published ? ($blog->published_at ?? now()) : null;
        $blog->reading_time = $blog->getReadingTimeAttribute();

        // Handle featured image removal
        if ($request->has('remove_featured_image')) {
            if ($blog->featured_image) {
                Storage::disk('public')->delete($blog->featured_image);
                $blog->featured_image = null;
            }
        }

        // Handle new featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($blog->featured_image) {
                Storage::disk('public')->delete($blog->featured_image);
            }
            
            $path = $request->file('featured_image')->store('blog-images', 'public');
            $blog->featured_image = $path;
        }

        $blog->save();

        if ($request->has('tags')) {
            $blog->tags()->sync($request->tags);
        }

        return redirect()->route('admin.blog.index')->with('success', 'Blog post berhasil diupdate!');
    }

    // Admin - Delete blog
    public function destroy(BlogPost $blog)
    {
        if ($blog->featured_image) {
            Storage::disk('public')->delete($blog->featured_image);
        }
        
        $blog->delete();
        return redirect()->route('admin.blog.index')->with('success', 'Blog post deleted successfully!');
    }

    // User - View all published blogs
    public function view()
    {
        $search = request('search');
        $categoryId = request('category');
        $tagSlug = request('tag');

        $query = BlogPost::with(['category', 'author', 'tags'])
            ->where('is_published', true)
            ->where('published_at', '<=', now());

        // Search functionality
        if ($search) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('content', 'like', '%' . $search . '%');
        }

        // Filter by category
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        // Filter by tag
        if ($tagSlug) {
            $query->whereHas('tags', function($q) use ($tagSlug) {
                $q->where('slug', $tagSlug);
            });
        }

        $posts = $query->latest('published_at')->paginate(10);

        $popularPosts = BlogPost::with(['category', 'author'])
            ->where('is_published', true)
            ->where('published_at', '<=', now())
            ->orderBy('view_count', 'desc')
            ->take(5)
            ->get();

        // PERBAIKAN: Menggunakan cara yang lebih eksplisit
        $categories = BlogCategory::withCount([
            'posts as published_posts_count' => function($query) {
                $query->where('is_published', true)
                    ->where('published_at', '<=', now());
            }
        ])->get();

        return view('blog.user', compact('posts', 'popularPosts', 'categories', 'search'));
    }

    // User - View single blog post
    public function show($slug)
    {
        $post = BlogPost::with(['category', 'author', 'tags'])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->where('published_at', '<=', now())
            ->firstOrFail();

        // Increment view count
        $post->incrementViewCount();

        $popularPosts = BlogPost::with(['category', 'author'])
            ->where('is_published', true)
            ->where('published_at', '<=', now())
            ->where('id', '!=', $post->id)
            ->orderBy('view_count', 'desc')
            ->take(5)
            ->get();

        $relatedPosts = BlogPost::with(['category', 'author'])
            ->where('category_id', $post->category_id)
            ->where('is_published', true)
            ->where('published_at', '<=', now())
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        // PERBAIKAN: TAMBAHKAN VARIABLE CATEGORIES UNTUK SIDEBAR
        $categories = BlogCategory::withCount([
            'posts as published_posts_count' => function($query) {
                $query->where('is_published', true)
                    ->where('published_at', '<=', now());
            }
        ])->get();

        return view('blog.artikel', compact('post', 'popularPosts', 'relatedPosts', 'categories'));
    }
}