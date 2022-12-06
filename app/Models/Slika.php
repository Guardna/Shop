<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;

class Slika {

	public $id;
	public $putanja;

	public function save(){
		$id = DB::table('slika')
				->insertGetId([
					'putanja' => $this->putanja
				]);
		return $id;
	}
        public function find($id)
    {
        return \DB::table($this->table)
            ->where('id', $id)
            ->get()
            ->first();
    }

    public function delete($id)
    {
        return \DB::table($this->table)
            ->delete($id);
    }
}
