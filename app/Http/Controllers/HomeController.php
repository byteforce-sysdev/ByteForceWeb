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
            [ "partners" => array(
                array(
                    "weblink" => "https://primecareclinic.co.id",
                    "title" => "Primecare Clinic",
                    "image" => asset("images/partners/partner-pcc.png")
                ),
                array(
                    "weblink" => "https://fiberstar.co.id",
                    "title" => "FiberStar",
                    "image" => asset("images/partners/partner-fs.png")
                ),
//                array(
//                    "weblink" => "https://emoona.byteforceid.com",
//                    "title" => "Emoona Studio",
//                    "image" => asset("images/partners/partner-emoona.jpg")
//                ),
                array(
                    "weblink" => "http://grandabehotel.com",
                    "title" => "Grand Abe Hotel",
                    "image" => asset("images/partners/partner-gah.png")
                ),
                array(
                    "weblink" => "http://akuato.com",
                    "title" => "Akuato",
                    "image" => asset("images/partners/partner-akuato.png")
                ),
                array(
                    "weblink" => "https://hub.gspace.id/",
                    "title" => "GSpace",
                    "image" => asset("images/partners/partner-gspace.png")
                ),
            )]     // TODO: Placeholder Data
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
