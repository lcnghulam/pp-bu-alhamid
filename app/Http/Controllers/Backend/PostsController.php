<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Yajra\DataTables\DataTables;

use App\Models\Post;
use App\Models\PostsSubCategory;
use App\Models\PostsTag;
use App\Models\PostsRelation;

class PostsController extends Controller
{
    public function index()
    {
        return view('backend.pages.posts', [ 'title' => 'Posts' ]);
    }

    public function getData(Request $request)
    {
        try {
            $posts = Post::with([
                'author:id,name',
                'posts_relations.posts_subcategory:id,sub_category',
                'posts_relations.posts_tag:id,tag'
            ])
            ->select(['id', 'post_judul', 'post_date', 'post_category', 'slug', 'post_status', 'author_id']) // **Tidak ambil `post_isi`**
            ->orderBy('id', 'desc');
            
            // dd($posts->toSql(), $posts->getBindings());
            return DataTables::of($posts)
                ->addColumn('title', function($row) {
                    return '<span class="fw-bold">' . $row->post_judul . '</span>';
                })
                ->addColumn('category', function($row) {
                    return $row->post_category;
                })
                ->addColumn('sub_category', function($row) {
                    return $row->posts_relations->map(function ($relation) {
                        return optional($relation->posts_subcategory)->sub_category; // Hindari error jika relasi kosong
                    })->filter()->unique()->implode(', '); // Hapus nilai kosong dan gabungkan dengan koma & gabungkan jika sama (unique)
                })
                ->addColumn('tag', function($row) {
                    return $row->posts_relations->map(function ($relation) {
                        $tag = optional($relation->posts_tag)->tag;
                        if (!$tag) return null;
                
                        // Buat warna HEX berdasarkan hash dari tag
                        $hash = crc32($tag);
                        $color = sprintf("#%06X", $hash & 0xFFFFFF); // Ambil 6 digit terakhir dari hash
                
                        return '<span class="badge" style="border: 1px solid ' . $color . '; color: ' . $color . '; background-color: transparent;">' . e($tag) . '</span>';
                    })->filter()->join(' ');
                })
                ->addColumn('author', function($row) {
                    return optional($row->author)->name;
                })
                ->editColumn('post_date', function ($row) {
                    return Carbon::parse($row->post_date)->format('d-m-Y H:i:s');
                })
                ->addColumn('date', function ($row) {
                    Carbon::setLocale('id'); // Set bahasa Indonesia
                    return Carbon::parse($row->post_date)->translatedFormat('d F Y'); // Format: 16 Maret 2025
                })
                ->addColumn('status', function ($row) {
                    return $row->post_status == 0 ? 
                    '<span class="badge bg-warning">Draft</span>' 
                    : 
                    '<span class="badge bg-success">Published</span>';
                })
                ->addColumn('aksi', function ($row) {
                    return '<button data-slug="' . $row->slug . '" id="btnEdit"><i class="align-middle" data-feather="edit-2"></i></button>
                            <button data-slug="' . $row->slug . '" id="btnDestroy"><i class="align-middle" data-feather="trash"></i></button>';
                })
                ->rawColumns(['title', 'category', 'sub_category', 'tag', 'author', 'date', 'status', 'aksi'])
                ->make(true);
        } catch (\Exception $e) {
        
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }

    }

    public function tambah()
    {
        $subCategory = PostsSubCategory::all();

        return view('backend.pages.posts.tambah', [ 
            'title' => 'Tambah Post', 
            'subCategory' => $subCategory, 
        ]);
    }

    public function store(Request $request)
    {
        try {
            // Start Validate
            $validatedPost = $request->validate([
                'post_judul'    => 'required|string|max:255',
                'post_category' => 'required|in:Artikel,Berita',
                'post_img'      => 'nullable|image|mimes:jpg,png,jpeg|max:1000',
                'post_isi'      => 'required|string',
                'post_status'   => 'required|in:0,1',
            ]);
            
            $validatedSubCategory = $request->validate([
                'sub_category' => 'required|string|max:50',
            ]);
        
            $tags = $request->tag;
            if (is_string($tags)) {
                $tags = explode(',', $tags);
            }
        
            $validatedTag = Validator::make(['tag' => $tags], [
                'tag'   => 'required|array',
                'tag.*' => 'required|string|max:50',
            ])->validate();
            


            // Start Transaction
            DB::beginTransaction();
        
            $validatedPost['author_id'] = Auth::id();
            $validatedPost['post_date'] = Carbon::now('Asia/Jakarta'); // Waktu sesuai GMT+7
        
            $words = explode('-', Str::slug($validatedPost['post_judul'], '-'));
            $slug = implode('-', array_slice($words, 0, 10));
            if (Post::where('slug', $slug)->exists()) {
                $validatedPost['slug'] = $slug . '-' . uniqid();
            } else {
                $validatedPost['slug'] = $slug;
            }

            if ($request->hasFile('post_img')) {
                $filename = $validatedPost['slug'] . '-' . uniqid() . '.' . $request->file('post_img')->getClientOriginalExtension();
                $validatedPost['post_img'] = $filename;
            }
        
            $post = Post::create($validatedPost);
            
            if($request->subcat_type == 'new') {
                $subCategory = PostsSubCategory::create($validatedSubCategory);
            } else if ($request->subcat_type == 'exist') {
                $subCategory = PostsSubCategory::where('id', $request->sub_category)->first();
            }
        
            $tagIds = [];
            foreach ($validatedTag['tag'] as $tagName) {
                $tag = PostsTag::firstOrCreate(['tag' => $tagName]);
                $tagIds[] = $tag->id;
            }
        
            foreach ($tagIds as $tagId) {
                PostsRelation::create([
                    'post_id'         => $post->id,
                    'subcategory_id' => $subCategory->id,
                    'tag_id'          => $tagId,
                ]);
            }

            // Start Commit / Execute All to DB
            // dd($validatedPost,$validatedSubCategory,$validatedTag);
            DB::commit();
            if ($request->hasFile('post_img')) {
                $request->file('post_img')->storeAs('posts', $filename, 'public');
            }
        
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil ditambahkan!',
                'post' => $post,
            ]);
        } catch (\Exception $e) {
            // IF Error
            DB::rollBack();
        
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
        
    }

    public function edit(Request $request)
    {
        if ($request->ajax()) {
            $post = Post::where('slug', $request->slug)->value('id');
            // dd($post);
            
            if (!$post) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan!'
                ], 404);
            }
            
            session(['edit_post_allowed' => true]);

            return response()->json([
                'success' => true
            ]);
        } 

        if (!session()->has('edit_post_allowed')) {
            abort(403);
        }
        
        session()->forget('edit_post_allowed');

        $post = Post::where('slug', $request->query('post'))->first();
        $subCategory = PostsSubCategory::all();
        
        $subCatId = PostsRelation::where('post_id', $post->id)
                    ->value('subcategory_id');
        $selectedTags = PostsRelation::where('post_id',$post->id)
                        ->with('posts_tag:id,tag')
                        ->get()
                        ->pluck('posts_tag.tag', 'posts_tag.id')
                        ->toArray();
        // dd($subCatId);
        // dd($selectedTags);

        if (!$post) {
            abort(404);
        }

        return view('backend.pages.posts.edit', [
            'title' => 'Edit Post',
            'post' => $post,
            'subCategory' => $subCategory,
            'subCatId' => $subCatId,
            'selectedTags' => $selectedTags,
        ]);
    }

    public function update(Request $request)
    {
        try {
            $slug = $request->query('post');
            $post = Post::where('slug', $slug)->first();
    
            $validatedPost = $request->validate([
                'post_judul'    => 'required|string|max:255',
                'post_category' => 'required|in:Artikel,Berita',
                'post_img'      => 'nullable|image|mimes:jpg,png,jpeg|max:1000',
                'post_isi'      => 'required|string',
                'post_status'   => 'required|in:0,1',
            ]);
            
            $validatedSubCategory = $request->validate([
                'sub_category' => 'required|string|max:50',
            ]);
        
            $tags = $request->tag;
            if (is_string($tags)) {
                $tags = explode(',', $tags);
            }
        
            $validatedTag = Validator::make(['tag' => $tags], [
                'tag'   => 'required|array',
                'tag.*' => 'required|string|max:50',
            ])->validate();



            // Start Transaction
            DB::beginTransaction();
            

            $validatedPost['post_date'] = Carbon::now('Asia/Jakarta'); // Waktu sesuai GMT+7
            
            $words = explode('-', Str::slug($validatedPost['post_judul'], '-'));
            $slug = implode('-', array_slice($words, 0, 10));
            if (Post::where('slug', $slug)->exists()) {
                $validatedPost['slug'] = $slug . '-' . uniqid();
            } else {
                $validatedPost['slug'] = $slug;
            }
        
            $changesPost = [];
            foreach ($validatedPost as $key => $value) {
                if (!is_null($value) && $post->$key != $value) {
                    $changesPost[$key] = $value;
                }
            }

            if ($request->hasFile('post_img')) {
                $filename = $validatedPost['slug'] . '-' . uniqid() . '.' . $request->file('post_img')->getClientOriginalExtension();
                $changesPost['post_img'] = $filename;
            }

            if (!empty($changesPost)) {
                $post->update($changesPost);
            }
            
            if($request->subcat_type == 'new') {
                $subCategory = PostsSubCategory::create($validatedSubCategory);
            } else if ($request->subcat_type == 'exist') {
                $subCategory = PostsSubCategory::where('id', $request->sub_category)->first();
            }
        
            $tagIds = [];
            foreach ($validatedTag['tag'] as $tagName) {
                $tag = PostsTag::firstOrCreate(['tag' => $tagName]);
                $tagIds[] = $tag->id;
            }
        
            PostsRelation::where('post_id',$post->id)->delete();
            foreach ($tagIds as $tagId) {
                PostsRelation::create([
                    'post_id'         => $post->id,
                    'subcategory_id' => $subCategory->id,
                    'tag_id'          => $tagId,
                ]);
            }

            // Delete Unused SubCat & Tag
            PostsSubCategory::doesntHave('posts_relations')->delete();
            PostsTag::doesntHave('posts_relations')->delete();

            // Start Commit / Execute All to DB
            // dd($validatedPost,$validatedSubCategory,$validatedTag);
            DB::commit();
            
            if ($request->hasFile('post_img')) {
                $fotoPath = "posts/" . $filename; 
                
                if (Storage::disk('public')->exists($fotoPath)) {
                    Storage::disk('public')->delete($fotoPath);
                }
                $request->file('post_img')->storeAs('posts', $filename, 'public');
            }

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui!',
                'updated_fields' => array_keys($changesPost), // Menampilkan field yang berubah
            ]);

        } catch (\Exception $e) {
            // IF Error
            DB::rollBack();
        
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
    
    public function destroy(Request $request)
    {
        try {
            DB::beginTransaction();

            $post = Post::where('slug', $request->slug)->first();
            // dd($post);

            $postRelations = PostsRelation::where('post_id', $post->id)->get();

            $title = $post->post_judul;
            $author = $post->author->name;

            foreach ($postRelations as $relation) {
                $isSubCategoryUsed = PostsRelation::where('subcategory_id', $relation->subcategory_id)
                    ->where('post_id', '!=', $post->id)
                    ->exists();

                if (!$isSubCategoryUsed) {
                    PostsSubCategory::where('id', $relation->subcategory_id)->delete();
                }

                $isTagUsed = PostsRelation::where('tag_id', $relation->tag_id)
                    ->where('post_id', '!=', $post->id)
                    ->exists();

                if (!$isTagUsed) {
                    PostsTag::where('id', $relation->tag_id)->delete();
                }
            }

            PostsRelation::where('post_id', $post->id)->delete();

            $fotoPath = $post->post_img ? "posts/{$post->post_img}" : null;

            $post->delete();

            // Commit transaksi
            DB::commit();

            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }

            return response()->json([
                'success' => true,
                'message' => "Data Post dengan <br>Judul : <strong>{$title}</strong><br>Author : <strong>{$author}</strong><br>berhasil dihapus!"
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => "Terjadi kesalahan: " . $e->getMessage()
            ], 500);
        }
    }


}
