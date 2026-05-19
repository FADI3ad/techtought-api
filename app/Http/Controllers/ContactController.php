<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Store a new contact message (Public).
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        $contact = Contact::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Your message has been sent successfully. We will get back to you soon!',
            'data' => $contact
        ], 201);
    }

    /**
     * List all contact messages (Admin).
     */
    public function index()
    {
        $messages = Contact::latest()->paginate(15);

        return response()->json([
            'status' => 'success',
            'data' => $messages
        ]);
    }

    /**
     * Mark a message as read (Admin).
     */
    public function markAsRead(Contact $contact)
    {
        $contact->update(['is_read' => true]);

        return response()->json([
            'status' => 'success',
            'message' => 'Message marked as read'
        ]);
    }

    /**
     * Delete a contact message (Admin).
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Message deleted successfully'
        ]);
    }
}
