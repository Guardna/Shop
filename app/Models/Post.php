<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;

class Post {
	public $id;
	public $naslov;
	public $sadrzaj;
	public $korisnik_id;
	public $slika_id;
    public $price;
    public $ColorId;
    public $CategoryId;
    public $popust;
	private $table = 'post';

	public function getAll(){
		$rezultat = DB::table('post')
					->select('*','post.id as postId','post.created_at as create','post.updated_at as update')
					->join('slika as s','post.slika_id','=','s.id')
					->join('korisnik as k','post.korisnik_id','=','k.id')
                                        ->join('uloga as u','k.uloga_id','=','u.id')
					->orderBy('post.created_at','desc')
					->get();
		return $rezultat;
	}


	public function save() {
		$rezultat = DB::table('post')->insert([
			'naslov' => $this->naslov,
			'sadrzaj' => $this->sadrzaj,
            'price'=>$this->price,
			'korisnik_id' => $this->korisnik_id,
            'ColorId' => $this->ColorId,
            'CategoryId' => $this->CategoryId,
			'created_at' => time(),
			'slika_id' => $this->slika_id
		]);
		$log = DB::table('logs')->insert([
			'user' =>session()->get('user')[0]->korisnicko_ime,
			'action' => 'Made new post '.$this->naslov,
			'time' => time()
		]);
	}


    public function get($id){
        $rezultat =
                DB::table($this->table)
                ->select('*',
                        'post.id AS postId',
                        'post.created_at as create',
                        'post.updated_at as update',
                        'korisnik.korisnicko_ime as postKorisnik',
                        'k.korisnicko_ime as komentarKorisnik',
                        'comments.post_id as comments')
                ->join('slika','slika.id','=','post.slika_id')
                ->join('korisnik','korisnik.id','=','post.korisnik_id')
                ->leftJoin('comments','comments.post_id','=','post.id')
                ->leftJoin('korisnik AS k','k.id','=','comments.user_id')
                ->where('post.id','=',$id )
                ->first();
        return $rezultat;
    }

    public function getp() {
	$rezultat = DB::table('post')
				->select('*')
				->where('id',$this->id)
				->first();
	return $rezultat;
}
    public function update(){
		$data = [
			'naslov' => $this->naslov,
			'sadrzaj' => $this->sadrzaj,
            'price'=>$this->price,
            'ColorId' => $this->ColorId,
            'CategoryId' => $this->CategoryId,
            'popust' => $this->popust,
                        'updated_at' => time(),
		];

                if ($this->slika_id != null) {
                $data['slika_id'] = $this->slika_id;
                }

		$rez = DB::table('post')
		->where('id',$this->id)
		->update($data);
		$log = DB::table('logs')->insert([
			'user' =>session()->get('user')[0]->korisnicko_ime,
			'action' => 'Updated post '.$this->naslov,
			'time' => time()
		]);
        return $rez;
	}


	public function delete(){
        $post = DB::table('post')
            ->select('*')
            ->where('id',$this->id)
            ->first();
        $postname=$post->naslov;
		$rezultat = DB::table('post')
					->where('id', $this->id)
					->delete();
		$log = DB::table('logs')->insert([
		'user' =>session()->get('user')[0]->korisnicko_ime,
		'action' => 'Deleted post '.$postname,
		'time' => time()]);
		return $rezultat;
	}
        public function deleted(){
		$rezultat = DB::table('slika')
					->where('id', $this->slika_id)
					->delete();
		return $rezultat;
	}
        public function getPictureId($postId)
    {
        return \DB::table($this->table)
            ->where('id', $postId)
            ->select("slika_id")
            ->get()->first();
    }

}
