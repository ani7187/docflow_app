<?php
namespace App\Documents;

use App\Models\document\Document;
use Illuminate\Database\Eloquent\Collection;

class EloquentRepository implements DocumentsRepository
{
    public function search(string $query = ''): Collection
    {
        return Document::query()
            ->where('name', 'like', "%{$query}%")
            ->orWhere('notes', 'like', "%{$query}%")
            ->get();
    }
}
