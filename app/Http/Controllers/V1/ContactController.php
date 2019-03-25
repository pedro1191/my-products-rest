<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    protected $phoneRegex = '/^(\(?\+?55\)?)?[- ]?\(?\d{2}\)?[- ]?(\d{1})?[- ]?(\d{4})[- ]?(\d{4})$/';

    public function __construct(\App\Contact $contact, \App\Transformers\ContactTransformer $transformer)
    {
        $this->contact = $contact;
        $this->transformer = $transformer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = $this->contact->paginate(Controller::DEFAULT_PAGINATION_RESULTS);

        return $this->response->paginator($contacts, $this->transformer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // User input validation
        $this->validate($request, [
            'name' => ['required', 'min:1', 'max:100'],
            'email' => ['required', 'email', 'min:1', 'max:100'],
            'phone' => ['sometimes', 'required', "regex:{$this->phoneRegex}"],
            'message' => ['required', 'min:1', 'max:1000'],
        ]);

        // Everything OK
        $contact = $this->contact->create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone') ?? null,
            'message' => $request->input('message')
        ]);

        \Log::info('Guest ' . $contact->name . ' sent a message with id ' . $contact->id . '...');

        return $this->response->item($contact, $this->transformer)->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!($contact = $this->contact->find($id))) {
            return $this->response->errorNotFound();
        }

        return $this->response->item($contact, $this->transformer);
    }
}
