<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Korisnik;

class LoginController extends Controller {

	public function login(Request $request){
		$request->validate([
			'tbKorisnickoIme' => ['required','alpha'],
		], [
			'required' => ' :attribute is required!'
		]);

		$korisnickoIme = $request->get('tbKorisnickoIme');
		$lozinka = $request->get('tbLozinka');

		$korisnik = new Korisnik();
		$korisnik->korisnicko_ime = $korisnickoIme;
		$korisnik->lozinka = $lozinka;

		$loginKorisnik = $korisnik->getByUsernameAndPassword();

		if(!empty($loginKorisnik)){
			$request->session()->push('user', $loginKorisnik);
			return redirect()->back()->with('success','Successful Login!');
		}
		return redirect()->back()->with('error','You are not registered!');
	}

	public function logout(Request $request){
		$request->session()->forget('user');
		$request->session()->flush();
		return redirect('/');
	}
}
