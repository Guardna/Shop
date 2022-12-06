<?php

namespace App\Http\Controllers;

use App\Models\CommentsModel;
use App\Models\Post;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    private $data = [];

    public function postCommentjs(int $sid,String $keyword)
    {
                    $commentsModel = new CommentsModel();
                    $commentsModel->content = $keyword;
                    $commentsModel->post_id = $sid;
                    try {
                        $commentsModel->save();
                        $output='';
                        $post = new Post();
                        $this->data['singlePost'] = $post->get($sid);

                        $commentModel = new CommentsModel();
                        $this->data['comments'] = $commentModel->getPostComments($sid);
                        if($this->data['singlePost']){
                            $output .= '<div class="col-md-8">' .
                                '<h1 class="mt-4">'.$this->data['singlePost']->naslov.'</h1>' .
                                '<p class="lead">' .
                                'by&nbsp' .
                                '<a href="#">'.$this->data['singlePost']->postKorisnik.'</a>' .
                                '</p><hr>' .
                                '<p>Posted on '.date("d.m.Y. H:i:s", $this->data['singlePost']->create).'</p><hr>' .
                                '<img class="img-fluid rounded" src="'.asset("/".$this->data['singlePost']->putanja).'"><hr>' .
                                '<p> '.$this->data['singlePost']->sadrzaj.'</p><hr>' .
                                '<div class="card mb-4">';

                            if(session()->get('user')){
                                $output .= '<div class="card my-4">' .
                                    '<h5 class="card-header">Leave a Comment:</h5>' .
                                    '<div class="card-body">' .
                                    '<form action="#" method="get">' .
                                    csrf_field() .
                                    '<div class="form-group">'.
                                    '<textarea class="form-control" id="psalji" rows="3" name="content"></textarea></div>' .
                                    '<button name="akcija" value="post" onclick="salji('.$this->data['singlePost']->postId.')" class="btn btn-primary salji">Submit</button>' .
                                    '</form><br></div></div>'.
                                    '<div hidden>' .
                                    '<form id="pform" action="'.route("editComment", ["postId" => $this->data['singlePost']->postId],["commentId" =>"2"]).'" method="post">' .
                                    csrf_field() .
                                    '<div class="form-group">' .
                                    '<textarea class="form-control" id="txta" rows="3" name="content1"></textarea></div>' .
                                    '<button type="submit" name="akcija" value="edit" class="btn btn-primary">Update</button></form></div>';
                                if($this->data['comments']){
                                    $output .= '<div class="comments heading"><h3>Comments</h3><form id="komentform">';
                                    foreach ($this->data['comments'] as $comment){
                                        $output .= '<div class="media"><div class="media-body"><table class="table"><tr><td>' .
                                            '<h4 class="media-heading">'.$comment->korisnicko_ime.'</h4>' .
                                            '<h6><label>'.date("F j, Y", strtotime($comment->created_at)).'</label></h6>' .
                                            '<span id="comment'.$comment->id.'">' .
                                            '<span id="kom'.$comment->id.'">'.$comment->content.'</span></br>';
                                        if(session()->get('user')[0]->id == $comment->user_id || session()->get('user')[0]->naziv == 'admin'){
                                            $output .= '<a href="'.route("deleteComment", ["commentId" => $comment->id]).'"><i class="fa fa-trash">Obrisi</i></a>&nbsp';
                                        }
                                        if(session()->get('user')[0]->id == $comment->user_id){
                                            $output .= '<a href="#comment'.$comment->id.'"><i class="fa fa-edit" onclick="editComment('.$comment->id.','.$this->data['singlePost']->postId.')">Izmeni</i></a>';
                                        }
                                        $output .= '<span id="#comments"></span></span></td></tr></table></div><div class="media-right"></div></div>';
                                    }
                                    $output .= '</form></div>';
                                }
                            }else{
                                $output .= '<h4>Da bi komentarisali morate da se ulogujete.</h4>';
                            }$output .= '</div>';

                        }

                        return response()->json($output);
                    } catch (QueryException $e) {
                        \Log::error("Greska pri dodavanju komentara " . $e->getMessage());
                        return redirect()->back()->with('warning', "Doslo je do greske na serveru.");
                    }


    }
    /*public function postKoment(Request $request)
    {
                    $commentsModel = new CommentsModel();
                    $commentsModel->content = $request->get('content');
                    $commentsModel->post_id = $request->get("postid");
                    $id=$request->get("postid");
                    try {
                        $commentsModel->save();
                        $this->data[] = $commentsModel->getPostComments($id)-;
                        return response()->json($this->data);
                    } catch (QueryException $e) {
                        \Log::error("Greska pri dodavanju komentara " . $e->getMessage());
                        return redirect()->back()->with('warning', "Doslo je do greske na serveru.");
                    }

    }*/

    public function editComment(Request $request, $commentId)
    {
        switch($request->akcija) {
            case 'edit':
        $commentModel = new CommentsModel();
        try {
            $commentModel->content = $request->get('content1');
            $commentModel->update($commentId);
            return redirect()->back()->with('success', "Komentar uspesno izmenjen.");
        } catch (\Exception $e) {
            \Log::error("Greska pri izmeni komentara " . $e->getMessage());
            return redirect()->back()->with('warning', "Doslo je do greske na serveru.");
        }
        break;
    }

    }

    public function deleteComment($commentId)
    {
        $commentModel = new CommentsModel();
        if ($commentModel->find($commentId)) {
            try {
                if ($commentModel->delete($commentId)) {
                    return redirect()->back()->with("success", "Comment successfully deleted.");
                } else {
                    \Log::critical("Korisnik bez dozvoljenih prava pokusao da obrise komentar.");
                    return redirect()->back()->with("warning", "An error has occurred, please try again later.");
                }
            } catch (QueryException $e) {
                \Log::error("Greska pri brisanju komentara  " . $e->getMessage());
                return redirect()->back()->with("warning", "An error has occurred, please try again later.");
            }
        }
        return redirect()->back();
    }

    public function show($commentId)
    {
        $commentModel = new CommentsModel();
        $this->data['comments'] = $commentModel->getPostComments($commentId);

		if(!empty($commentId)){
			$commentModel->id = $commentId;
			$this->data['comment'] = $commentModel->getPostComments($commentId);
        return view('components.comments', $this->data);

    }

                }
}
