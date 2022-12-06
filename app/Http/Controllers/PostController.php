<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Color;
use App\Models\Invoice;
use App\Models\InvoiceLine;
use Validator;
use App\Models\CommentsModel;
use App\Models\Meni;
use App\Models\Post;
use App\Models\Slika;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;



class PostController extends Controller {

	private $data = [];

    public function __construct(){
    	$meni = new Meni();
        $colors = Color::all();
        $categories=Category::all();
        $this->data['colors'] = $colors;
        $this->data['categories'] = $categories;
    	$this->data['menus'] = $meni->getAll();
    }

	public function create(){

		return view('pages.createPost', $this->data);
	}

	public function store(Request $request) {


		$rules = [
			'title' => 'regex:/^[A-Z][a-z]+(\s[\w\d\-]+)*$/',
			'body' => 'required',
            'pboje' => 'required',
            'pkategorije' => 'required',
			'photo' => 'required|mimes:jpg,jpeg,png,gif|max:3000'
		];
		$custom_messages = [
			'required' => ' :attribute is required!',
			'title.regex' => 'Title must start with a capital letter!',
			'max' => 'File cant be bigger than :max KB.',
			'mimes' => 'Allowed formats are: :values.'
		];
		$request->validate($rules, $custom_messages);

		$photo = $request->file('photo');
		$extension = $photo->getClientOriginalExtension();
		$tmp_path = $photo->getPathName();

		$folder = 'images/';
		$file_name = time().".".$extension;
		$new_path = ($folder).$file_name;

		try {


			File::move($tmp_path, $new_path);



			$slika = new Slika();
			$slika->putanja = 'images/'.$file_name;
			$slika_id = $slika->save();


			$post = new Post();
			$post->naslov = $request->get('title');
			$post->sadrzaj = $request->get('body');
            $post->price = $request->get('cena');
            $post->ColorId = $request->get('pboje');
            $post->CategoryId = $request->get('pkategorije');
            $post->korisnik_id = session()->get('user')[0]->id;
			$post->slika_id = $slika_id;
			$post->save();

			return redirect('/')->with('success','Successfully Added!');
		}
		catch(\Illuminate\Database\QueryException $ex){
			\Log::error($ex->getMessage());
			return redirect()->back()->with('error','Database error!');
		}
		catch(\Symfony\Component\HttpFoundation\File\Exception\FileException $ex) {
			\Log::error('Problem sa fajlom!! '.$ex->getMessage());
			return redirect()->back()->with('error','Photo add error!');
		}
		catch(\ErrorException $ex) {
			\Log::error('Problem sa fajlom!! '.$ex->getMessage());
			return redirect()->back()->with('error','Error..');
		}
	}
        public function postshow($id = null){
		$post = new Post();
		$this->data['postovi'] = $post->getAll();

		if(!empty($id)){
			$post->id = $id;
			$this->data['post'] = $post->get($id);
		}

		return view('pages.createPost', $this->data);
	}

        public function update(Request $request,$id) {
                $rules = [
			'title' => 'regex:/^[A-Z][a-z]+(\s[\w\d\-]+)*$/',
			'body' => 'required',
                    'pboje' => 'required',
                    'pkategorije' => 'required',
			'photo' => 'mimes:jpg,jpeg,png,gif|max:3000',
		];
		$custom_messages = [
			'required' => ' :attribute is required!',
			'title.regex' => 'Title is not in the correct format!',
			'max' => 'File cant be bigger than :max KB.',
			'mimes' => 'Allowed formats are: :values.'
		];
		$request->validate($rules, $custom_messages);


            $oldPictureId = null;

			$photo = $request->file('photo');
            $post = new post();
            $post->id = $id;
            $post->naslov = $request->get('title');
            $post->sadrzaj = $request->get('body');
            $post->price = $request->get('cena');
            $post->ColorId = $request->get('pboje');
            $post->CategoryId = $request->get('pkategorije');
            $post->popust = $request->get('popust');
			$post->slika_id=$post->get($id)->slika_id;
			$oldPictureId = $post->getPictureId($id);
            $puti=$request->get('puti');
			if (!empty($photo)){

							try{

								$rezz=$post->deleted();
								$folder = ('images/');
								$extension = $photo->getClientOriginalExtension();
								$file_name = time().".".$extension;
								$photo->move($folder, $file_name);

								$slika = new Slika();
								$slika->putanja = 'images/' . $file_name;
								$slika_id = $slika->save();
								$post->slika_id = $slika_id;


							}catch (QueryException $e) {
					\Log::error("Update Error: " . $e->getMessage());
				} catch (FileException $e) {
					\Log::error("Photo Update Error: " . $e->getMessage());
				}
			   }
                $rez=$post->update();

				if($rez == 1){
				return redirect('/posts')->with("success", "Post successfully edited!");
			}else {
				return redirect('/posts')->with('error','Update Error!');
			}


            }





        public function destroy($id){

        $nodel=InvoiceLine::where('PostId','=',$id)->first();
        if(!empty($nodel)){
            return redirect('/posts')->with('error','Product is in a order!');
        }
		$post = new Post();
		$post->id = $id;

                $post->slika_id=$post->get($id)->slika_id;

                $rezz=$post->deleted();


		$rez = $post->delete();
		if($rez == 1 && $rezz==1){
			return redirect('/posts')->with('success','Successful Delete!');
		}
		else {
			return redirect('/posts')->with('error','Delete Error!');
		}
	}
}
