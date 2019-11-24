<?php

namespace App\Http\Controllers;

use App\Mail\ContactUsMailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Home index view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view(
            'home.index',
            [ "partners" => [0,1,2,3,4,5] ]     // TODO: Placeholder Data
        );
    }

    public function createContactUsMessage(Request $request) {

        $data = array(
            'contactName' =>  $request->contactName,
            'contactEmail' =>  $request->contactEmail,
            'contactMessage' => $request->contactMessage,
            'mailto' => config('mail.username'),
            'mailPW' => config('mail.password'),
            'mailport' => config('mail.port'),
            'mailEncryption' => config ('mail.encryption'),
            'mailhost' => config ('mail.host'),

        );

//        return json_encode($data);

        try{
            Mail::to(config('mail.username'))->send(new ContactUsMailable($data));
        } catch (\Exception $e) {
            return response($e, 500);
        }

        return response(json_encode(array(
            "message" => "Message successfully sent."
        )), 200);
    }
}
