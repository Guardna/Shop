<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceLine;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index(Request $request) {
        $cart = $request->session()->get("cart");

        $invoice = new Invoice();


        $invoice->CustomerId = $request->session()->get('user')[0]->id;
        $invoice->InvoiceDate = Carbon::now("UTC");
        $invoice->ImePrezime=$request->session()->get("user")[0]->ImePrezime;
        $invoice->BillingAddress=$request->session()->get("user")[0]->BillingAddress;
        $invoice->BillingCity=$request->session()->get("user")[0]->BillingCity;
        $invoice->BillingState=$request->session()->get("user")[0]->BillingState;
        $invoice->BillingPostalCode=$request->session()->get("user")[0]->BillingPostalCode;
        $invoice->Phone=$request->session()->get("user")[0]->Phone;
        $invoice->email=$request->session()->get("user")[0]->email;
        $invoiceId = Invoice::max("InvoiceId")+1;
        $invoice->InvoiceId = $invoiceId;

        $lines = [];

        $total = 0;

        $lineId = InvoiceLine::max("InvoiceLineId") + 1;

        foreach($cart as $c) {
            $line = new InvoiceLine();
            $line->InvoiceId = $invoiceId;
            $line->Quantity = $c->quantity;
            $line->UnitPrice = $c->price;
            $line->PostId = $c->postId;
            $line->InvoiceLineId = $lineId++;
            $total += $c->quantity * $c->price;
            $lines[] = $line;
        }

        $invoice->Total = $total;

        try {
            DB::beginTransaction();

            $invoice->save();

            foreach($lines as $line) {
                $line->save();
            }

            DB::commit();

            $request->session()->remove("cart");

        }catch(\Exception $e) {
            DB::rollBack();
            echo $e->getMessage();
        }
    }
}
