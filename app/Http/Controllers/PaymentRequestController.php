<?php

namespace App\Http\Controllers;

use App\Models\PaymentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentRequestController extends Controller
{
    public function index(Request $request)
    {
        $payments = null;
        if ($request->search != null)
        {
            $payments = PaymentRequest::where('description','LIKE',"%{$request->search}%")
            ->orWhere('project','LIKE',"%{$request->search}%")
            ->paginate(100);
        }
        else $payments = PaymentRequest::paginate(100);
        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        return view("payments.create");
    }

    public function store(Request $request)
    {
        $validiranZahtjev = $request->validate([
            'description' => 'required|string|min:5|max:255',
            'project' => 'required|string|min:5|max:255',
            'person' => 'required|string|min:5|max:255',
            'reciept_number' => 'required|string|min:2|max:255',
            'reciept_date' => 'required|date|before_or_equal:'.now()->format('m/d/Y'),
            'cost' => 'required|min:0',
            'bank_account_number' => 'required|string|min:2|max:255',
            'comment' => 'nullable|string|max:256',
            'image' => 'nullable|image|max:5128',
        ]);

        if ($request->image){
            //Obrada slike
            $ekstenzija = $request->file('image')->getClientOriginalExtension();
            //Kreiranje naziva slike
            $naziv = 'racun'.'_'.time().'.'.$ekstenzija;
            //Uplad slike
            $path = $request->file('image')->storeAs('public/img/racuni', $naziv);
            $path = 'storage'.trim($path, "public");   
            //U bazi pamtimo samo ime
            $validiranZahtjev['image'] = $path;
        }

        $payment = PaymentRequest::create($validiranZahtjev);

        return redirect(route('payment.index'))->with('jsAlert', 'Uspjesno ste kreirali zahtjev za uplatu!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentRequest  $paymentRequest
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentRequest $paymentRequest)
    {
        
    }

    public function edit($id)
    {
        $paymentRequest = PaymentRequest::findOrFail($id);
        return view("payments.edit", compact('paymentRequest'));
    }

    public function update(Request $request, $id)
    {
        $validiranZahtjev = $request->validate([
            'description' => 'required|string|min:5|max:255',
            'project' => 'required|string|min:5|max:255',
            'person' => 'required|string|min:5|max:255',
            'reciept_number' => 'required|string|min:2|max:255',
            'reciept_date' => 'required|date|before_or_equal:'.now()->format('m/d/Y'),
            'cost' => 'required|min:0',
            'bank_account_number' => 'required|string|min:2|max:255',
            'comment' => 'nullable|string|max:256',
            'image' => 'nullable|image|max:5128',
        ]);
        $paymentRequest = PaymentRequest::findOrFail($id);
        if ($request->image){
            //Obrada slike
            $ekstenzija = $request->file('image')->getClientOriginalExtension();
            //Kreiranje naziva slike
            $naziv = 'racun'.'_'.time().'.'.$ekstenzija;
            //Uplad slike
            $path = $request->file('image')->storeAs('public/img/racuni', $naziv);
            $path = 'storage'.trim($path, "public");   
            //U bazi pamtimo samo ime
            $validiranZahtjev['image'] = $path;

            //Brisanje stare fotografije
            $old_photo=$paymentRequest->image;
            $old_photo = 'public'.substr($old_photo, strlen('storage'));
            Storage::delete($old_photo);
        }
        $paymentRequest->update($validiranZahtjev);
        return redirect(route('payment.index'))->with('jsAlert', 'Uspjesno ste izmjenili zahtjev '.$paymentRequest->description.'!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentRequest  $paymentRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $paymentRequest = PaymentRequest::findOrFail($id);
        $old_photo=$paymentRequest->image;
        $old_photo = 'public'.substr($old_photo, strlen('storage'));
        Storage::delete($old_photo);
        PaymentRequest::destroy($id);
        return redirect(route('payment.index'))->with('jsAlert', 'Uspjesno ste obrisali zahtjev!');
    }
}
