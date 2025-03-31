<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use App\Providers\WhatsAppService;

class WhatsappController extends Controller
{
    protected $whatsapp;

    public function __construct(WhatsAppService $whatsapp)
    {
        $this->whatsapp = $whatsapp;
    }


    public function index()
    {
        return view('Test.whatsapp');
    }
    /**
     * @throws GuzzleException
     */
    public function send(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validate = $request->validate([
            'phone' => 'required',
            'templateName' => 'required|string',
            'templateLanguage' => 'required|string',

        ]);
//        $phone = $request->input('phone');
//        $templateName = $request->input('templateName');
//        $templateLanguage = $request->input('templateLanguage');

        $response = $this->whatsapp->sendMessage($request->phone, $request->templateName, $request->templateLanguage);

        return redirect()->back()->with('success', 'Message envoyé avec succès !');
    }

}
