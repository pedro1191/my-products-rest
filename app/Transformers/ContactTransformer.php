<?php
namespace App\Transformers;

use League\Fractal;

class ContactTransformer extends Fractal\TransformerAbstract
{
    public function transform(\App\Contact $contact)
    {
        return [
            'id' => (int) $contact->id,
            'name' => $contact->name,
            'description' => $contact->email,
            'phone' => $contact->phone,
            'message' => $contact->message,
            'link' => app('Dingo\Api\Routing\UrlGenerator')->version('v1')->route('api.contacts.show', ['id' => $contact->id]),
        ];
    }
}
