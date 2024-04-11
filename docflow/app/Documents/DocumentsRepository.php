<?php
namespace App\Documents;

use Illuminate\Database\Eloquent\Collection;

interface DocumentsRepository
{
    public function search(string $query = ''): Collection;
}
