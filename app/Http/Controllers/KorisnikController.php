<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Color;
use App\Models\Meni;
use App\Models\Uloga;
use App\Models\Korisnik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class KorisnikController extends Controller {

	private $data = [];

	public function __construct() {
		$uloga = new Uloga();
		$this->data['uloge'] = $uloga->getAll();
        $colors = Color::all();
        $categories=Category::all();
        $this->data['colors'] = $colors;
        $this->data['categories'] = $categories;
                $meni = new Meni();
                $this->data['menus'] = $meni->getAll();
	}

	public function show($id = null){
		$korisnik = new Korisnik();
		$this->data['korisnici'] = $korisnik->getAll();

		if(!empty($id)){
			$korisnik->id = $id;
			$this->data['korisnik'] = $korisnik->get();
		}

		return view('pages.createKorisnik', $this->data);
	}
        public function regshow($id = null){
		$korisnik = new Korisnik();
		$this->data['korisnici'] = $korisnik->getAll();

		if(!empty($id)){
			$korisnik->id = $id;
			$this->data['korisnik'] = $korisnik->get();
		}

		return view('pages.register', $this->data);
	}

	public function store(Request $request){

                $rules=[
			'korisnickoIme' => 'required','unique:korisnik,korisnicko_ime','min:4',
                        'ddlUloga' => 'required','not_in:0',
                        'lozinka' => [
                            'required',
                            'min:6',
                            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/'],
			'slika' => 'required','mimes:jpg,jpeg,png,gif',
                    'imeprezime' => 'required',
                    'adresa' => 'required',
                    'grad' => 'required',
                    'opstina' => 'required',
                    'postanski' => 'required',
                    'telefon' => 'required'
		];

                $messages = [
                "lozinka.regex" => 'Password must contain one uppercase letter and one number.'];

                $validator = \Validator::make($request->all(), $rules, $messages);
                $validator->validate();


		$korisnicko_ime = $request->get('korisnickoIme');
		$lozinka = $request->get('lozinka');
		$uloga_id = $request->get('ddlUloga');
        if($uloga_id=='0'){
            $uloga_id = "2";
        }
        $ImePrezime= $request->get('imeprezime');
        $BillingAddress= $request->get('adresa');
        $BillingCity= $request->get('grad');
        $BillingState= $request->get('opstina');
        $BillingPostalCode= $request->get('postanski');
        $Phone= $request->get('telefon');
        $email=$request->get('email');

		$slika = $request->file('slika');

		$tmp_putanja = $slika->getPathName();
		$ekstenzija = $slika->getClientOriginalExtension();
		$ime_fajla = time().'.'.$ekstenzija;
		$putanja = 'images/'.$ime_fajla;

		$putanja_server = ($putanja);

		try {
			File::move($tmp_putanja, $putanja_server);


			$korisnik = new Korisnik();
			$korisnik->korisnicko_ime = $korisnicko_ime;
			$korisnik->lozinka = $lozinka;
			$korisnik->slika = $putanja;
			$korisnik->uloga_id = $uloga_id;
            $korisnik->ImePrezime= $ImePrezime;
            $korisnik->BillingAddress= $BillingAddress;
            $korisnik->BillingCity= $BillingCity;
            $korisnik->BillingState= $BillingState;
            $korisnik->BillingPostalCode= $BillingPostalCode;
            $korisnik->Phone= $Phone;
            $korisnik->email= $email;

			$rez = $korisnik->save();
			if($rez == 1){
				return redirect('/users')->with('success','Success!');
			}
			else {
				return redirect('/users')->with('error','Error!');
			}
		}
		catch (\Exception $ex){
			\Log::error('My Error: '.$ex->getMessage());
		}
	}
        public function regstore(Request $request){

		$rules=[
			'korisnickoIme' => ['required','unique:korisnik,korisnicko_ime','min:4'],
                        'lozinka' => [
                            'required',
                            'min:6',
                            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/'],
			'slika' => 'required','mimes:jpg,jpeg,png,gif',
            'imeprezime' => 'required',
            'adresa' => 'required',
            'grad' => 'required',
            'opstina' => 'required',
            'postanski' => 'required',
            'email' => ['required','unique:korisnik,email','regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix']
		];

                $messages = [
                "lozinka.regex" => 'Password must contain one uppercase letter and one number.'];

                $validator = \Validator::make($request->all(), $rules, $messages);
                $validator->validate();

		$korisnicko_ime = $request->get('korisnickoIme');
		$lozinka = $request->get('lozinka');
		$uloga_id = "2";
        $ImePrezime= $request->get('imeprezime');
        $BillingAddress= $request->get('adresa');
        $BillingCity= $request->get('grad');
        $BillingState= $request->get('opstina');
        $BillingPostalCode= $request->get('postanski');
        $Phone= $request->get('telefon');
            $email=$request->get('email');
		$slika = $request->file('slika');

		$tmp_putanja = $slika->getPathName();
		$ekstenzija = $slika->getClientOriginalExtension();
		$ime_fajla = time().'.'.$ekstenzija;
		$putanja = 'images/'.$ime_fajla;

		$putanja_server = ($putanja);
		try {
			File::move($tmp_putanja, $putanja_server);


			$korisnik = new Korisnik();
			$korisnik->korisnicko_ime = $korisnicko_ime;
			$korisnik->lozinka = $lozinka;
			$korisnik->slika = $putanja;
			$korisnik->uloga_id = $uloga_id;
            $korisnik->ImePrezime= $ImePrezime;
            $korisnik->BillingAddress= $BillingAddress;
            $korisnik->BillingCity= $BillingCity;
            $korisnik->BillingState= $BillingState;
            $korisnik->BillingPostalCode= $BillingPostalCode;
            $korisnik->Phone= $Phone;
            $korisnik->email= $email;
			$rez = $korisnik->save();

			if($rez == 1){
				return redirect('/register')->with('success','Success!');
			}
			else {
				return redirect('/register')->with('error','Error!');
			}
		}
		catch (\Exception $ex){
			\Log::error('MOJA GRESKA: '.$ex->getMessage());
		}
	}

	public function update($id, Request $request) {
		$korisnicko_ime = $request->get('korisnickoIme');
        $slozinka=$request->get('lozinka1');
		$lozinka = $request->get('lozinka');
        if($request->session()->get('user')[0]->naziv=='admin') {
            $uloga_id = $request->get('ddlUloga');
        }else{
            $uloga_id = 2;
        }
        $ImePrezime= $request->get('imeprezime');
        $BillingAddress= $request->get('adresa');
        $BillingCity= $request->get('grad');
        $BillingState= $request->get('opstina');
        $BillingPostalCode= $request->get('postanski');
        $Phone= $request->get('telefon');
        $email=$request->get('email');
		$slika = $request->file('slika');

		$korisnik = new Korisnik();


		$korisnik->id = $id;
        $olduser=$korisnik->get();
        $oldpass=$olduser->lozinka;
        $korisnik->ImePrezime= $ImePrezime;
        $korisnik->BillingAddress= $BillingAddress;
        $korisnik->BillingCity= $BillingCity;
        $korisnik->BillingState= $BillingState;
        $korisnik->BillingPostalCode= $BillingPostalCode;
        $korisnik->Phone= $Phone;
        $korisnik->email= $email;
        $korisnik->korisnicko_ime = $korisnicko_ime;

        if($request->session()->get('user')[0]->naziv=='admin'){
            $korisnik->lozinka = $slozinka;}else{
            if ($oldpass == md5($lozinka)) {
                $korisnik->lozinka = $lozinka;
            } else {
                return redirect('/users/'.session()->get('user')[0]->id)->with('error', 'Old password doesnt match!');
            }
        }
		$korisnik->uloga_id = $uloga_id;

		if(!empty($slika)){


			$korisnik_to_update = $korisnik->get();
			File::delete($korisnik_to_update->slika);


			$tmp_putanja = $slika->getPathName();
			$ime_fajla = time().'.'.$slika->getClientOriginalExtension();
			$putanja = 'images/'.$ime_fajla;
			$putanja_server = ($putanja);

			File::move($tmp_putanja, $putanja_server);

			$korisnik->slika = $putanja;
		}

		$rez = $korisnik->update();

		if($rez == 1){
            if($request->session()->get('user')[0]->naziv=='admin') {
                return redirect('/users')->with('success', 'Successful Update!');
            }else return redirect('/')->with('success', 'Successful Update!');
		}
		else {
			return redirect('/users')->with('error','Update Error');
		}
	}

	public function destroy($id){
		$korisnik = new Korisnik();
		$korisnik->id = $id;

		$korisnik_to_update = $korisnik->get();
		File::delete($korisnik_to_update->slika);

		$rez = $korisnik->delete();
		if($rez == 1){
			return redirect('/users')->with('success','Successful Delete!');
		}
		else {
			return redirect('/users')->with('error','Delete Error!');
		}
	}
}
