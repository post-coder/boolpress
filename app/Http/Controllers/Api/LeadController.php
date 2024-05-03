<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\NewContact;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    
    // memorizzando il nuovo contatto nel nostro db
    public function store(Request $request) {

        // validazione
        // ricordiamoci di importare la Facade
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required|email',
            'message' => 'required'
        ], [
            'name.required' => "Devi inserire il tuo nome",
            'address.required' => "Devi inserire la tua email",
            'address.email' => "Devi inserire una mail corretta",
            'message.required' => "Devi inserire un messaggio",
        ]);

        
        // comportamento in caso la validazione non sia di successo
        if($validator->fails()) {
            // restituiamo un oggetto json con il messaggio di errore
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
            
        }


        // salvataggio nel db
        $newLead = new Lead();
        $newLead->fill($request->all());
        $newLead->save();


    
        // invio della mail
        Mail::to('gabrielspanu96@gmail.com')->send(new NewContact($newLead));



        // risposta al client
        // restituisce un json con success true
        return response()->json([
            'success' => true,
            'message' => 'Richiesta di contatto inviata correttamente',
            'request' => $request->all()
        ]);
    }

}
