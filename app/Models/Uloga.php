<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;

class Uloga {

	private $table = 'uloga';
	public $id;
	public $naziv;

	public function getAll(){
		$rezultat = DB::table($this->table)->get();
		return $rezultat;
	}

	public function get(){
		return DB::table($this->table)
				->select('*')
				->where('id',$this->id)
				->first();
	}

	public function save(){
		$rez= DB::table($this->table)
			->insert([
				'naziv' => $this->naziv
			]);
			$log = DB::table('logs')->insert([
				'user' =>session()->get('user')[0]->korisnicko_ime,
				'action' => 'Added Uloga '.$this->naziv,
				'time' => time()
			]);
		return $rez;
	}

	public function update(){
		$rez=DB::table($this->table)
			->where('id', $this->id)
			->update([
				'naziv' => $this->naziv
			]);
			$log = DB::table('logs')->insert([
				'user' =>session()->get('user')[0]->korisnicko_ime,
				'action' => 'Updated Uloga '.$this->naziv,
				'time' => time()
			]);
		return $rez;
	}

	public function delete(){
		$rez=DB::table($this->table)
			->where('id', $this->id)
			->delete();
			$log = DB::table('logs')->insert([
				'user' =>session()->get('user')[0]->korisnicko_ime,
				'action' => 'Deleted Uloga '.$this->id,
				'time' => time()
			]);
		return $rez;
	}


}
