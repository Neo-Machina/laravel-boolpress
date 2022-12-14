<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Category;
use App\Tag;
use Illuminate\Support\Facades\Storage;
use App\Mail\SendNewMail;
use Illuminate\Support\Facades\Mail;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::orderBy('updated_at', 'desc')->paginate(6);
        
        $request_info = $request->all();

        $deleted_post_alert = isset($request_info['deleted']) ? $request_info['deleted'] : null; 

        $data = [
            'posts' => $posts,
            'deleted_post_alert' => $deleted_post_alert
        ];

        return view('admin.posts.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $categories = Category::all();

        $tags= Tag::all();

        $data = [
            'categories' => $categories,
            'tags' => $tags
        ];

        return view('admin.posts.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->getValidationRules());

        $form_data = $request->all();

        if(isset($form_data['image'])) {
            $img_path = Storage::put('post_covers', $form_data['image']);

            $form_data['cover'] = $img_path;
        }

        $new_post = new Post();

        $new_post->fill($form_data);

        $new_post->slug = $this->getFreeSlugFromTitle($new_post->title);

        $new_post->save();

        if(isset($form_data['tags'])) {
            $new_post->tags()->sync($form_data['tags']);
        } 

        // Inviare l'email all'amministratore per avvertirlo del nuovo post
        Mail::to('admin@email.com')->send(new SendNewMail($new_post));

        return redirect()->route('admin.posts.show', ['post' => $new_post->id]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);

        $now = Carbon::now();

        $dates_diff = $post->created_at->diffInDays($now);

        $data = [
            'post' => $post,
            'dates_diff' => $dates_diff
        ];

        return view('admin.posts.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();

        $tags = Tag::all();

        $data = [
            'post' => $post,
            'categories' => $categories,
            'tags' => $tags
        ];

        return view('admin.posts.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $request->validate($this->getValidationRules());

        $form_data = $request->all();

        $post_to_update = Post::findOrFail($id);
        
        // Gestione immagine:
        // se l'immagine ?? dichiarata nel $form_data
        if(isset($form_data['image'])) {
            // Calcello dal disco l'immagine vecchia se gi?? essa esiste
            if($post_to_update->cover) {
                Storage::delete($post_to_update->cover);
            }
            // faccio l'upload del nuovo file $img_path
            $img_path = Storage::put('posts_cover', $form_data['image']);
            // popolo $form_data con l'immagine
            $form_data['cover'] = $img_path;
        }

        if($form_data['title'] !== $post_to_update->title) {
            $form_data['slug'] = $this->getFreeSlugFromTitle($form_data['title']);
        } else {
            $form_data['slug'] = $post_to_update->slug;
        }
        
        if(isset($form_data['remove-image'])) {
            if($post_to_update->cover) {
                Storage::delete($post_to_update->cover);
            }

            $form_data['cover'] = null;
        }

        $post_to_update->update($form_data);

        if(isset($form_data['tags'])) {
            $post_to_update->tags()->sync($form_data['tags']);
        } else {
            $post_to_update->tags()->sync([]);
        }

        return redirect()->route('admin.posts.show', ['post' => $post_to_update->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post_to_delete = Post::findOrFail($id);

        if($post_to_delete->cover) {
            Storage::delete($post_to_delete->cover);
        }

        $post_to_delete->tags()->sync([]);
        $post_to_delete->delete();

        return redirect()->route('admin.posts.index', ['deleted' => 'yes']);
    }

    protected function getValidationRules() {
        return [
            'title' => 'required|max:255',
            'content' => 'required|max:65000',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|exists:tags,id',
            'image' => 'mimes:jpg,jpeg,png,gif,webp,svg|max:1024|nullable'
        ];
    }

    protected function getFreeSlugFromTitle($title) {
        // Assegnare lo slag
        $slug_to_save = Str::slug($title, '-');
        $slug_base = $slug_to_save;
        // Verificare se lo slag esiste nel database
        $existing_slug_post = Post::where('slug', '=', $slug_to_save)->first();

        // Finch?? non si trova uno slag libero, si appende un numero allo slag base -1, -2, ecc...
        $counter = 1;
        while($existing_slug_post) {
            // Si crea un nuovo slag con $counter
            $slug_to_save = $slug_base . '-' . $counter;

            // Verificare se lo slag esiste nel database
            $existing_slug_post = Post::where('slug', '=', $slug_to_save)->first();

            $counter++;
        }

        return $slug_to_save;
    }
}
