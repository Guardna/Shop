<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Logs {
    public $fromdate;
    public $todate;
    
    public function getlogs(){
        $rezultat = DB::table('logs')->get();
        return $rezultat;
    }
    public function getlog($fromdate,$todate){
        $newfromdate=$fromdate.' 00:00:00';
        $newtodate=$todate. '23:59:59';
        $newfrom=\Carbon\Carbon::parse($newfromdate)->timestamp;
        $newto=\Carbon\Carbon::parse($newtodate)->timestamp;
        $rezultat = DB::table('logs')
        ->select('*')
		->whereBetween('time',array($newfrom,$newto))
        ->get();
        return $rezultat;
    }
}
