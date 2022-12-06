<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Color;
use App\Models\Invoice;
use App\Models\InvoiceLine;
use App\Models\PostEloquentModel;
use App\Models\Post;
use App\Models\Meni;
use App\Models\SlikaEloquent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mail;
class CartController extends Controller
{
    private $data = [];

    public function __construct(){
        $meni = new Meni();
        $this->data['menus'] = $meni->getAll();
        $colors = Color::all();
        $categories=Category::all();
        $this->data['colors'] = $colors;
        $this->data['categories'] = $categories;
    }
    public  function index(Request $request) {
        try {
            $postId = $request->get("id");

            if(!$request->session()->has("cart")) {
                $request->session()->put("cart", []);
            }

            $post = PostEloquentModel::with('slika')->find($postId);
            $cart = $request->session()->get("cart");
            $popust=$post->popust;
            $cena=($post->price)-(($post->price)*($popust/100));
            $slike=SlikaEloquent::find($post->slika_id);

            if(isset($cart[$postId])) {
                $alreadyInCart = $cart[$postId];

                $alreadyInCart->quantity++;

                $cart[$postId] = $alreadyInCart;
            } else {
                $item = new \stdClass();
                $item->postId = $postId;
                $item->quantity = 1;
                $item->price =$cena;
                $item->image = $slike->putanja;
                $item->name = $post->naslov;
                $cart[$postId] = $item;
            }

            $request->session()->put("cart", $cart);
        } catch(\Exception $e) {
            echo $e->getMessage();
        }
    }
    public  function adjustQuantity(Request $request) {
        $postId = $request->get("id");
        $quantity = $request->get("quantity");

        $cart = $request->session()->get("cart");

        if(isset($cart[$postId])) {
            $alreadyInCart = $cart[$postId];

            $alreadyInCart->quantity = $quantity;

            $cart[$postId] = $alreadyInCart;

            $request->session()->put("cart", $cart);
        }

    }

    public function get(Request $request) {
        $cart = $request->session()->get("cart");

        if(!$cart) {
            $cart = [];
        }

        return view("pages.cart", [
            "cartItems" => $cart ], $this->data);
    }
    public  function remove($postId, Request  $request) {

        $cart = $request->session()->get("cart");
        if(isset($cart[$postId])) {
            unset($cart[$postId]);
            $request->session()->put("cart", $cart);
        }
    }
    public function myOrders() {
        $user=session()->get('user')[0]->id;
        if(session()->get('user')[0]->naziv=='admin'){
            $orders = Invoice::with("invoicelines.post")->get();
        }else {
            $orders = Invoice::with("invoicelines.post")->where("CustomerId", $user)->get();
        }
        return view("pages.orders", [
            "orders" => $orders
        ], $this->data);
    }

    public function destroy($id)
    {
        try {
            $res=Invoice::where('InvoiceId',$id)->delete();
            $res2=InvoiceLine::where('InvoiceId',$id)->delete();
            return redirect()->back()->with("success", "Delete successfull.");
        }catch(\Exception $ex) {
            return redirect()->back()->with("error", $ex->getMessage());
        }
    }
    public function send(Request $request)
    {
        $invoiceid=$request->id;

        $invoice = new Invoice();

        $voice =Invoice::find($invoiceid);

        $mail=$voice->email;

        $mess="Your Order has been shipped:";


        $data = ['name' => 'Flower Shop' , 'email' => $mail , 'messageBody' => $mess ];

        Mail::send('emails.email', $data, function ($message) use ($data)
        {
            $message->from($data['email'], $data['name']);
            $message->to($data['email'], 'Customer')
                ->subject('Order Shipped');
        });

        return redirect()
            ->back()
            ->with('success', 'Email Sent');

    }
}
