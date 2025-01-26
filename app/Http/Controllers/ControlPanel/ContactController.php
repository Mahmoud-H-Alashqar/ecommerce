<?php

namespace App\Http\Controllers\ControlPanel;

use App\Models\Contact;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    // عرض جميع المنتجات
    public function index()
    {
        $contacts = Contact::paginate(10); 
        //dd($contacts);
        return view('ControlPanel.contacts.index', compact('contacts'));
    }

 

    // عرض تفاصيل منتج معين
    public function show(Contact $contact)
    {
       // dd($contact);
        return view('ControlPanel.contacts.show', compact('contact'));
    }

    
    
    // حذف منتج
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('control_panel_dashboard.contactadmin.index')
                         ->with('success', 'Contact deleted successfully!');
    }
}
