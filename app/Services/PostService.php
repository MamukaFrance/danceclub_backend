<?php

namespace App\Services;

use App\Repositories\Contracts\PostRepositoryInterface;
use App\Models\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Exceptions\PostException;
use Throwable;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;



class PostService
{
    public function __construct(
        protected PostRepositoryInterface $postRepository
    ) {}

    public function getAllPosts(): Collection
    {
        return $this->postRepository->all();
    }

     public function find(int $id): ?Post
    {
        return $this->postRepository->find($id);
    }

   public function create(PostRequest $request): Post
    {
        $data = $request->validated();
       
        try {
            return DB::transaction(function () use ($request, $data) {
                $this->handleImage($request, $data);
                $data['user_id'] = auth()->user()->id;
                return $this->postRepository->create($data);
            });

        } catch (Throwable $e) {
            Log::error('Post creation failed', [
                'exception' => $e,
                'data' => $data,
            ]);

            // if (isset($data['image'])) {
            //     Storage::disk('public')->delete($data['image']);            
            // }

            if (!empty($data['image_public_id'])) {
            Cloudinary::uploadApi()->destroy($data['image_public_id']);
            }

            throw new PostException('Impossible de créer le post');

        }
    }

    public function update(PostRequest $request, Post $post): Post
    {
        try {
            return DB::transaction(function () use ($request, $post) {
                // Validation
                $data = $request->validated();
                if ($request->has('remove_image') && $post->image_public_id) {
                Cloudinary::uploadApi()->destroy($post->image_public_id);
                
                $data['image'] = null;
                $data['image_public_id'] = null;
            }
                // Traitement de l'image
                if ($request->hasFile('image')) {
                    // if ($post->image) {
                    //     Storage::disk('public')->delete($post->image);
                    // }

                    // Supprimer ancienne image si elle existe
                    if ($post->image_public_id) {
                        Cloudinary::uploadApi()->destroy($post->image_public_id);
                    }

                    $this->handleImage($request, $data);
                }
                
                // Remplit sans sauvegarder
                $post->fill($data);
                // Aucune modification
                if (! $post->isDirty()) {
                    return $post;
                }
                // Sauvegarde
                return $this->postRepository->update($post, $data);
            });

        } catch (Throwable $e) {
            Log::error('Post update failed', [
                'exception' => $e,
                'post' => $post,
            ]);

            throw new PostException('Impossible de mettre à jour le post');
        }        
    }

    public function delete(Post $post): bool
    {
        try {
            // if ($post->image) {
                //     Storage::disk('public')->delete($post->image);
            // }
            if ($post->image_public_id) {
                Cloudinary::uploadApi()->destroy($post->image_public_id);
            }
            return $this->postRepository->delete($post);
            
        } catch (Throwable $e) {
            Log::error('Post delete failed', [
                'exception' => $e,
                'post' => $post,
            ]);

            throw new PostException('Impossible de supprimer le post');
        }

       
    }

    private function handleImage(PostRequest $request, array &$data): void
    {
        // if ($request->hasFile('image')) {
        //     $data['image'] = $request->file('image')
        //         ->store('images', 'public');
        // }

        if ($request->hasFile('image')) {
            $upload = Cloudinary::uploadApi()->upload(
                $request->file('image')->getRealPath()); 

            $data['image'] = $upload['secure_url'];
            $data['image_public_id'] = $upload['public_id'];
        }
    }
}