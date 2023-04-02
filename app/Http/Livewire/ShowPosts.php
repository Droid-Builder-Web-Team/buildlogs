<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Post;

class ShowPosts extends Component
{

    use WithPagination;

    public $logid = 0;

    public function mount($logid)
    {
        $this->logid = $logid;
    }

    public function render()
    {
        return view('livewire.show-posts', [
            'posts' => Post::where('build_log_id', $this->logid)->paginate(5),
        ]);
    }
}
