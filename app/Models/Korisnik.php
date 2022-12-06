<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;

class Korisnik
{
	public $id;
	public $korisnicko_ime;
	public $lozinka;
	public $slika;
	public $uloga_id;
    public $ImePrezime;
    public $BillingAddress;
    public $BillingCity;
    public $BillingState;
    public $BillingPostalCode;
    public $Phone;
    public $email;

	public function getAll(){
		$rezultat = DB::table('korisnik')
					->select('*', 'korisnik.id AS korisnikId')
					->join('uloga','uloga.id','=','korisnik.uloga_id')
					->get();
		return $rezultat;
	}

	public function get() {
		$rezultat = DB::table('korisnik')
					->select('*')
					->where('id',$this->id)
					->first();
		return $rezultat;
	}

	public function getByUsernameAndPassword(){
		$rezultat = DB::table('korisnik')
					->select('korisnik.*','uloga.naziv')
					->join('uloga','korisnik.uloga_id', '=', 'uloga.id')
					->where([
						'korisnicko_ime' => $this->korisnicko_ime,
						'lozinka' => md5($this->lozinka)
					])
					->first();
		$log = DB::table('logs')->insert([
		'user' =>$this->korisnicko_ime,
		'action' => 'Login Korisnik '.$this->korisnicko_ime,
		'time' => time()]);
		return $rezultat;
	}

	public function save() {
		$rez = DB::table('korisnik')->insert([
			'korisnicko_ime' => $this->korisnicko_ime,
			'lozinka' => md5($this->lozinka),
            'ImePrezime' => $this->ImePrezime,
            'BillingAddress' => $this->BillingAddress,
            'BillingCity' => $this->BillingCity,
            'BillingState' => $this->BillingState,
            'BillingPostalCode' => $this->BillingPostalCode,
            'Phone' => $this->Phone,
            'email' => $this->email,
			'slika' => $this->slika,
			'uloga_id' => $this->uloga_id,
						'created_at' => time()]);
		$log = DB::table('logs')->insert([
		'user' =>$this->korisnicko_ime,
		'action' => 'Added Korisnik '.$this->korisnicko_ime,
		'time' => time()]);
		return $rez;
	}

	public function update(){
		$data = [
			'korisnicko_ime' => $this->korisnicko_ime,
			'lozinka' => md5($this->lozinka),
            'ImePrezime' => $this->ImePrezime,
            'BillingAddress' => $this->BillingAddress,
            'BillingCity' => $this->BillingCity,
            'BillingState' => $this->BillingState,
            'BillingPostalCode' => $this->BillingPostalCode,
            'Phone' => $this->Phone,
            'email' => $this->email,
			'uloga_id' => $this->uloga_id,
                        'updated_at' => time(),
		];

		if(!empty($this->slika)){
			$data['slika'] = $this->slika;
		}

		$rez = DB::table('korisnik')
		->where('id',$this->id)
				->update($data)
				;
		$log = DB::table('logs')->insert([
		'user' =>session()->get('user')[0]->korisnicko_ime,
		'action' => 'Updated Korisnik '.$this->korisnicko_ime,
		'time' => time()]);
		return $rez;
	}

	public function delete(){
        $user = DB::table('korisnik')
            ->select('*')
            ->where('id',$this->id)
            ->first();
        $username=$user->korisnicko_ime;
		$rezultat = DB::table('korisnik')
					->where('id', $this->id)
					->delete();
		$log = DB::table('logs')->insert([
		'user' =>session()->get('user')[0]->korisnicko_ime,
		'action' => 'Deleted Korisnik '.$username,
		'time' => time()]);
		return $rezultat;
	}
}
