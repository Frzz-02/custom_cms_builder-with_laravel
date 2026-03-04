<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    /**
     * Display a listing of newsletter subscribers
     */
    public function index()
    {
        $subscribers = Newsletter::latest()->paginate(15);
        return view('backend.newsletter.subscribers', compact('subscribers'));
    }

    /**
     * Remove the specified subscriber
     */
    public function destroy(Newsletter $newsletter)
    {
        $newsletter->delete();

        return redirect()->route('backend.newsletter.subscribers')
            ->with('success', 'Subscriber deleted successfully!');
    }
}
