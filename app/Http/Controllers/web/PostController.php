<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Services\PostService;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Exceptions\PostException;

class PostController extends Controller
{
    public function __construct(protected PostService $postService) 
    {
         // Middleware pour sécuriser certaines routes par rôle
        $this->middleware('role:admin|editor')->only(['create', 'store', 'edit', 'update']);
        // $this->middleware('role:admin')->only(['destroy']); // seule suppression réservée à l'admin 
    }

    public function index()
    {
        $posts = $this->postService->getAllPosts();
        return view('pages.posts', compact('posts'));
    }

    // Page pour créer un nouveau post
    public function create()
    {
        return view('pages.create-post');
    }

    // Page pour éditer un post existant
    public function edit(Post $post)
    {
        return view('pages.create-post', compact('post'));
    }

    // Sauvegarde d'un nouveau post
    public function store(PostRequest $request)
    {
        try {
            $this->postService->create($request);
            return redirect()
                ->route('post.index')
                ->with('success', 'Post créé avec succès');

        } catch (PostException $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
        
    }

    // Mise à jour d'un post existant
    public function update(PostRequest $request, Post $post)
    {
        try {
            $post = $this->postService->update($request, $post);
            if (! $post->wasChanged()) {
                return redirect()
                    ->route('post.index')
                    ->with('info', 'Aucune modification détectée');
            }

            return redirect()
                ->route('post.index')
                ->with('success', 'Post mis à jour avec succès');    
        } catch (PostException $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        } 
    }

    // Supprimer un post
    public function destroy(Post $post)
    {
        try{
            $this->postService->delete($post);
            return redirect()
                ->route('post.index')
                ->with('success', 'Post supprimé avec succès');
        }catch (PostException $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
}