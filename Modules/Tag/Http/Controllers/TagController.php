<?php

namespace Modules\Tag\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Modules\Tag\Http\Requests\Store;
use Modules\Tag\Models\Tag;
use Modules\Tag\Service\TagService;

class TagController extends Controller
{
    private TagService $tag_service;
    
    public function __construct(TagService $tag_service)
    {
        $this->middleware('permission:tags-list');
        $this->middleware('permission:tags-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:tags-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:tags-delete', ['only' => ['destroy']]);
        $this->tag_service = $tag_service;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('tag::index', ['tags' => $this->tag_service->index()]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  Store  $request
     *
     * @return RedirectResponse
     */
    public function store(Store $request): RedirectResponse
    {
        $this->tag_service->store($request->validated());
        
        return redirect()->route('post-tag.index');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('tag::create', ['tags' => new Tag()]);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  Tag  $tag
     *
     * @return Application|Factory|View
     */
    public function edit(Tag $tag)
    {
        return view('tag::edit', ['tag' => $this->tag_service->edit($tag->id)]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  Store  $request
     * @param  Tag  $tag
     *
     * @return RedirectResponse
     */
    public function update(Store $request, Tag $tag): RedirectResponse
    {
        $this->tag_service->update($request->validated(), $tag->id);
        
        return redirect()->route('post-tag.index');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  Tag  $tag
     *
     * @return RedirectResponse
     */
    public function destroy(Tag $tag): RedirectResponse
    {
        $this->tag_service->destroy($tag->id);
        
        return redirect()->route('tags.index');
    }
}