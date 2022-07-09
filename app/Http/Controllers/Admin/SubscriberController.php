<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index()
    {
        $page_title = 'Subscriber Manager';
        $empty_message = 'No subscriber yet.';
        $subscribers = Subscriber::latest()->paginate(getPaginate());
        return view('admin.subscriber.index', compact('page_title', 'empty_message', 'subscribers'));
    }

    public function sendEmailForm()
    {
        $page_title = 'Send Email to Subscribers';
        return view('admin.subscriber.send_email', compact('page_title'));
    }

    public function remove(Request $request)
    {
        $request->validate(['subscriber' => 'required|integer']);
        $subscriber = Subscriber::findOrFail($request->subscriber);
        $subscriber->delete();

        $notify[] = ['success', 'Subscriber has been removed'];
        return back()->withNotify($notify);
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'body' => 'required',
        ]);
        if (!Subscriber::first()) return back()->withErrors(['No subscribers to send email.']);
        $subscribers = Subscriber::all();
        foreach ($subscribers as $subscriber) {
            $receiver_name = explode('@', $subscriber->email)[0];
            send_general_email($subscriber->email, $request->subject, $request->body, $receiver_name);
        }
        $notify[] = ['success', 'Email will be sent to all subscribers.'];
        return back()->withNotify($notify);
    }
}
