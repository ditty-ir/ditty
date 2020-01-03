<?php

namespace App\Classes;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Draft
{
    private $table = 'post_drafts';

    public function save(array $data): void
    {
        $content = mb_json_encode($data);
        $now = Carbon::now();

        if ($this->draftExists()) {
            DB::table($this->table)->where('user_id', Auth::id())->update([
                'content' => $content,
                'updated_at' => $now
            ]);
        } else {
            DB::table($this->table)->insert([
                'user_id' => Auth::id(),
                'content' => $content,
                'created_at' => $now,
                'updated_at' => $now
            ]);
        }
    }

    public function get()
    {
        $data = DB::table($this->table)->where('user_id', Auth::id())->first();

        if (!empty($data)) {
            return json_decode($data->content)->data;
        }
    }

    public function deleteDraft(): void
    {
        DB::table($this->table)->where('user_id', Auth::id())->delete();
    }

    public function draftExists(): bool
    {
        return DB::table($this->table)->where('user_id', Auth::id())->exists();
    }
}