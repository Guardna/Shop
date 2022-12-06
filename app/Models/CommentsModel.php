<?php

namespace App\Models;


class CommentsModel
{
    public $content;
    public $post_id;
    private $table = 'comments';

    public function save()
    {
        return \DB::table($this->table)
            ->insert([
               'user_id' => session()->get('user')[0]->id,
               'post_id' => $this->post_id,
                'content' => $this->content,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
    }

    public function update($id)
    {
        return \DB::table($this->table)
            ->where('id', $id)
            ->update([
               'content' => $this->content,
               'updated_at' => date("Y-m-d H:i:s")
            ]);
    }

    public function getPostComments($postId)
    {
        return \DB::table($this->table)
            ->join("korisnik", "comments.user_id", "=", "korisnik.id")
            ->where('post_id', $postId)
            ->select('comments.*', 'korisnik.korisnicko_ime')
            ->orderBy('comments.created_at','desc')    
            ->get();
    }

    public function delete($id)
    {
        if($this->canUserDeleteComment($id)) {
            return \DB::table($this->table)->delete($id);
        }
        return 0;
    }

    public function getUserComments($userId)
    {
        return \DB::table($this->table)->where('user_id', $userId)->get();
    }

    public function find($id)
    {
        return \DB::table($this->table)
            ->where('id', $id)->get()->first();
    }
    private function canUserDeleteComment($commentId)
    {
        $comment = $this->find($commentId);
        return $comment ? (session()->get('user')[0]->naziv == 'admin') || ($comment->user_id == session()->get('user')[0]->id) : false;
    }
}