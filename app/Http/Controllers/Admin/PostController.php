<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::where('user_id',Auth::id())->orderBy('created_at','desc')->paginate(5);
        return view('admin.posts.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags= Tag::all();
       return view('admin.posts.create',compact('tags'));
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
            'title'=>'required|min:5|max:100',
            'body'=>'required|min:5|max:500',
            'img'=> 'image'
        ]);
        $data =$request->all();
        $data['user_id']= Auth::id();
        $data['slug']= Str::slug($data['title'],'-');

        $newPost = new Post();

        if (!empty($data['img'])) {

            $data['img'] = Storage::disk('public')->put('images',$data['img']);
        }

        $newPost->fill($data);

        $saved=$newPost->save();

        if (!empty($data['tags'])){
            $newPost->tags()->attach($data['tags']);
        }

        if ($saved) {
            return redirect()->route('posts.index')->with('insert','Hai inserito correttamente il post.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post = Post::where('slug',$slug)->fist();
        return view('admin.posts.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
         $tags= Tag::all();
        return view('admin.posts.edit',compact('post','tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|min:5|max:100',
            'body' => 'required|min:5|max:500',
        ]);

        $data=$request->all();
        $data['slug']= Str::slug($data['title'],'-');
        $data['updated_at']= Carbon::now('Europe/Rome');

        if (!empty($data['tags'])) {

            $post->tags()->sync($data['tags']);
        }else{
            $post->tags()->detach();
        }

        if (!empty($data['img'])) {

            if (!empty($post->img)) {
                Storage::disk('public')->delete($post->img);
            }
            $data['img'] = Storage::disk('public')->put('images',$data['img']);
        }

        $updated = $post->update($data);

        if ($updated) {
            return  redirect()->route('posts.index')->with('update','Hai modificato correttamente il post del id ' . $post->id);
        }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('status','delete','Hai cancellato correttamente il post'.$post->id);
    }
}
