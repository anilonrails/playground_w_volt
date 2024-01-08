<?php

use function Livewire\Volt\{state, usesFileUploads, computed, rules};

usesFileUploads();

use App\Models\Post;
state([
    'title' => '',
    'body' => '',
    'image' => 'null',
]);

$posts = computed(fn() => Post::all());
rules([
    'title' => 'required|min:3',
    'body' => 'required|min:5',
    'image' => 'required|image|max:1024|mimes:png,jpg,jpeg',
]);
$addPost = function () {
    $this->validate();
    Post::create([
        'title' => $this->title,
        'body' => $this->body,
        'image' => $this->image->store('posts'),
    ]);
    $this->title = '';
    $this->body = '';
    $this->image = null;
};

?>

<div class="max-w-6xl mx-auto bg-slate-100 rounded">
    <div class="my-4">
        <form wire:submit.prevent="addPost" enctype="multipart/form-data" class="p-4 space-y-2">
            <div>
                <label for="title">Title</label>
                <input type="text" wire:model="title"
                    class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-md">
                @error('title')
                    <span class="text-red-400">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="body">Description</label>
                <textarea wire:model="body"
                    class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-md"></textarea>
                @error('body')
                    <span class="text-red-400">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="image">Image</label>
                <input type="file" wire:model="image"
                    class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-md">
                @error('image')
                    <span class="text-red-400">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="px-3 py-2 bg-indigo-500 rounded w-full text-white">Store</button>
        </form>
    </div>
    <div>
        @foreach ($this->posts as $post)
            <h2>{{ $post->title }}</h2>
        @endforeach
    </div>
</div>
