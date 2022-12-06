<?php
namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Color;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Meni;
use Mail;

class ContactUsController extends Controller
{
    public function index()
    {
        $meni = new Meni();
        $colors = Color::all();
        $categories=Category::all();
        $this->data['colors'] = $colors;
        $this->data['categories'] = $categories;
    	$this->data['menus'] = $meni->getAll();
        return view('pages.contact',$this->data);
    }

    public function handleForm(Request $request)
    {

        $this->validate($request, ['name' => 'required', 'email' => 'required|email', 'message_body' => 'required|min:20']);

        $data = ['name' => $request->get('name') , 'email' => $request->get('email') , 'messageBody' => $request->get('message_body') ];

        Mail::send('emails.email', $data, function ($message) use ($data)
        {
            $message->from($data['email'], $data['name']);
            $message->to('androidxx8@gmail.com', 'Admin')
                ->subject('Flower Shop');
        });

        return redirect()
            ->back()
            ->with('success', 'Thank you for your feedback');

    }

}
