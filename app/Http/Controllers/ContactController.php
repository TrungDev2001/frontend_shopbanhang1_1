<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Contact_customer;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    private $contact;
    private $contact_customer;
    public function __construct(Contact $contact, Contact_customer $contact_customer)
    {
        $this->contact = $contact;
        $this->contact_customer = $contact_customer;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contact = $this->contact->first();
        return view('menu.contact.index', compact('contact'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->contact_customer->create([
            'name_customer' => $request->name,
            'email_customer' => $request->email,
            'subject_customer' => $request->subject,
            'content_customer' => $request->message,
        ]);
        session()->put('seccessContact', 'seccessContact');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
