<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Color;
use App\Models\CommentsModel;
use App\Models\Meni;
use App\Models\Post;
use App\Models\Logs;
use App\Models\Korisnik;
use App\Models\PostEloquentModel;
use Illuminate\Http\Request;
use DB;

class FrontendController extends Controller {

    private $data = [];

    public function __construct(){
    	$meni = new Meni();
    	$this->data['menus'] = $meni->getAll();
        $colors = Color::all();
        $categories=Category::all();
        $this->data['colors'] = $colors;
        $this->data['categories'] = $categories;
    }
    public function index(){
    	$post = new Post();
        $this->data['posts'] =$post->getAll();

        $users = DB::table('post')->select('*','post.id as postId','post.created_at as create','post.updated_at as update')->join('slika as s','post.slika_id','=','s.id')->join('korisnik as k','post.korisnik_id','=','k.id')->join('uloga as u','k.uloga_id','=','u.id')->orderBy('post.created_at','desc');
        $this->data['users'] =$users->simplePaginate(8);

        return view('pages.home', $this->data);
    }
     public function galerija(){
        $post = new Post();
        $this->data['posts'] =$post->getAll();
        return view('pages.galerija', $this->data);
    }
    public function showlogs(){
        $logs = new Logs();
    	$this->data['logovi'] = $logs->getlogs();
        return view('pages.logovi' , $this->data);
    }
    public function trazi(Request $request) {

        $keyword = $request->keyword;
        $boja=$request->boje;
        $sort=$request->sortBy;
        $kat=$request->kategorije;
            $post = new Post();
           $this->data['posts'] =$post->getAll();

            $users = DB::table('post')->select('*','post.id as postId','post.created_at as create','post.updated_at as update')->join('slika as s','post.slika_id','=','s.id')->join('korisnik as k','post.korisnik_id','=','k.id')->join('uloga as u','k.uloga_id','=','u.id')->join('color as c','post.ColorId','=','c.ColorId')->join('category as g','post.CategoryId','=','g.CategoryId');

            if($sort!=0){
        if (!empty($sort) && $sort == 'Price-desc') {
            $users=$users->orderBy('price','DESC');
        }
        if (!empty($sort) && $sort == 'Price-asc') {
            $users=$users->orderBy('price','ASC');
        }
        if (!empty($sort) && $sort == 'Naslov-asc') {
            $users=$users->orderBy('naslov','ASC');
        }
        if (!empty($sort) && $sort == 'Naslov-desc') {
            $users=$users->orderBy('naslov','DESC');
        }}


        if($boja==0){
            if ($kat==0) {
                $this->data['users'] = $users->where('post.naslov', 'like', '%' . $keyword . '%')->simplePaginate(8);
            }else
            $this->data['users'] =$users->where('post.naslov','like','%'.$keyword.'%')->where('post.CategoryId','=',$kat)->simplePaginate(8);
        }elseif ($kat==0){
            $this->data['users'] =$users->where('post.naslov','like','%'.$keyword.'%')->where('post.ColorId','=',$boja)->simplePaginate(8);
        }else
      $this->data['users'] =$users->where('post.naslov','like','%'.$keyword.'%')->where('post.CategoryId','=',$kat)->where('post.ColorId','=',$boja)->simplePaginate(8);



        $users=$this->data['users'];

        return  view("pages.search",
            [
                "users" => $users,
            ],$this->data);
    }
    public function getPostjs($id){
        $output='';
        $post = new Post();
        $this->data['singlePost'] = $post->get($id);

        $commentModel = new CommentsModel();
        $this->data['comments'] = $commentModel->getPostComments($id);
        if($this->data['singlePost']){

            $output .= '<div class="col-md-8">' .
                '<h1 class="mt-4">'.$this->data['singlePost']->naslov.'</h1>' .
                '<p class="lead">' .
                'by&nbsp' .
                '<a href="#">'.$this->data['singlePost']->postKorisnik.'</a>' .
                '</p><hr>' .
                '<p>Posted on '.date("d.m.Y. H:i:s", $this->data['singlePost']->create).'</p><hr>' .
                '<img class="img-fluid rounded" src="'.asset("/".$this->data['singlePost']->putanja).'" ><hr>' .
                '<p> '.$this->data['singlePost']->sadrzaj.'</p><hr>' .
                '<p> '.$this->data['singlePost']->price.'</p><hr>';

            if($this->data['singlePost']->popust!=Null && $this->data['singlePost']->popust!=0){
                $output .='<p class="card-text">'.
                    '<p class="text-success">Discount '.$this->data['singlePost']->popust.'%<p>'.
                    '</p>';
            }
            $output .='<div class="card mb-4">';
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
                $output .= '<h4>You must login to comment.</h4>';
            }$output .= '</div>';

        }

        return response()->json($output);
    }
    public function getPost($id){
        $post = new Post();
        $this->data['singlePost'] = $post->get($id);

        $commentModel = new CommentsModel();
        $this->data['comments'] = $commentModel->getPostComments($id);

        return view('pages.post', $this->data);
    }

}
