<?php

namespace Modules\Post\Service;

use Illuminate\Http\Request;
use Modules\Category\Models\Category;
use Modules\Core\Service\CoreService;
use Modules\Core\Traits\ImageUpload;
use Modules\Post\Models\Post;
use Modules\Post\Repository\PostRepository;
use Modules\Tag\Models\Tag;
use Modules\User\Models\User;

class PostService extends CoreService
{
    use ImageUpload;

    public PostRepository $post_repository;

    public function __construct(PostRepository $post_repository)
    {
        $this->post_repository = $post_repository;
    }

    public function store($data): Post
    {
        $post = $this->post_repository->create($data);

        if (isset($data['category'])) {
            $post->categories()->attach($data['category']);
        }

        if (isset($data['tags'])) {
            $post->tags()->attach($data['tags']);
        }

        return $post;
    }


    public function edit(int $id): array
    {
        return [
            'categories' => Category::all(),
            'tags' => Tag::all(),
            'users' => User::all(),
            'post' => $this->post_repository->findById($id),
        ];
    }

    public function create(): array
    {
        return [
            'categories' => Category::all(),
            'tags' => Tag::all(),
            'users' => User::all(),
            'post' => new Post(),
        ];
    }

    public function update($data, $post): Post
    {
        $post->update($data);
        if (isset($data['category'])) {
            $post->categories()->sync($data['category']);
        }

        if (isset($data['tags'])) {
            $post->tags()->sync($data['tags']);
        }

        return $post;
    }


    public function destroy(int $id): void
    {
        $this->post_repository->delete($id);
    }

    public function search(array $data): mixed
    {
        return $this->post_repository->search($data);
    }

    public function getAll(): mixed
    {
        return $this->post_repository->findAll();
    }

    public function show(int $id): mixed
    {
        return $this->post_repository->findById($id);
    }

    /**
     * @param  Request  $request
     *
     * @return void
     */
    public function upload(Request $request): void
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;

            $request->file('upload')->move(public_path('images'), $fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/'.$fileName);
            $msg = 'Image uploaded successfully';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }
}
