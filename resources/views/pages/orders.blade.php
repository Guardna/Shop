@extends('layouts.front')

@section('title')
    Contact
@endsection

@section('appendCss')
    @parent
    <!-- Custom styles for this template -->
    <link href="{{ asset('/') }}css/blog-home.css" rel="stylesheet"/>
@endsection

@section('content')
    <!-- Sadrzaj -->
    <div class="col-md-8">
        <br><br>
        <table class="table table-bordered table-striped table-condensed">
            <tr>
                <th>OrderNum</th>
                <th>OrderDate</th>
                <th>Products</th>
                <th>Address</th>
                <th>Total</th>
            </tr>
            @php
                $total = 0;
            @endphp
            @foreach($orders as $o)
                <tr>
                    <td>{{ $o->InvoiceId }}</td>
                    <td>{{ $o->InvoiceDate }}</td>
                    <td>
                        @foreach($o->invoiceLines as $il)
                            {{ $il->Quantity." ".$il->post->naslov . "," }}
                        @endforeach
                    </td>
                    @if(session()->get('user')[0]->naziv == 'admin')
                    <td>
                        {{ $o->ImePrezime }}
                        <br>{{ $o->BillingAddress }}
                        <br>{{ $o->BillingCity }}
                        <br>{{ $o->BillingState }}
                        <br>{{ $o->BillingPostalCode }}
                        <br>{{ $o->Phone }}
                        <br>{{ $o->email }}
                    </td>
                    @endif
                    <td>
                        {{ $o->Total }}
                        @php $total += $o->Total; @endphp
                    </td>
                    @if(session()->has('user'))
                        @if(session()->get('user')[0]->naziv == 'admin')
                    <td> <a href="{{ asset('/order/destroy/'.$o->InvoiceId) }}" class="btn btn-danger">Delete</a>
                        <br><br>
                     <a href="{{ asset('/order/send/'.$o->InvoiceId) }}" class="btn btn-success">Send</a> </td>
                        @endif
                        @endif
                </tr>
            @endforeach
        </table>

        <p class="lead">Total amount: {{ $total }}$</p>

    </div>
    <!--// Sadrzaj -->
@endsection
