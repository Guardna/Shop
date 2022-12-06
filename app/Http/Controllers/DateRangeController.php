<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meni;
use App\Models\Logs;
use DB;

class DateRangeController extends Controller
{
    private $data = [];
    public function __construct(){
    	$meni = new Meni();
    	$this->data['menus'] = $meni->getAll();
    }
    function index(Request $request)
    {
        $logs = new Logs();
      if(!empty($request->fromdate))
      {
        $fromdate=$request->fromdate;
        $todate=$request->todate;
         $this->data['logovi']=$logs->getlog($fromdate, $todate);
      }
      else
      {    
    	$this->data['logovi'] = $logs->getlogs();
      }
     
     return view('pages.logovi',$this->data);
    }
}

?>