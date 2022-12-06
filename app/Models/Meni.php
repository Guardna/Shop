<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Meni {
    //put your code here
    
    public function getAll(){
        $rezultat = DB::table('meni')->get();
        return $rezultat;
    }
}
