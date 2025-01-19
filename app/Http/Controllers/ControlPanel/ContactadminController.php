<?php

namespace App\Http\Controllers\ControlPanel;

use App\Models\Contactadmin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactadminController extends Controller
{
    public function index()
    {
        $contactadminExists = Contactadmin::exists();
         $contactadmins = Contactadmin::paginate(10); 
         return view('controlpanel.contactadmins.index', compact('contactadmins','contactadminExists'));
    }

    public function create()
    {
        return view('controlpanel.contactadmins.create');
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'address' => 'required',
            'email' => 'required',
            'telephone' => 'required',
        ]);

        Contactadmin::create([
            'address' => $request->address,
            'email' => $request->email,
            'telephone' => $request->telephone,
        ]);

        return redirect()->route('control_panel_dashboard.contactadmins.index')->with('success', 'تم إضافة التصنيف بنجاح');
    }

    public function edit($id)
    {
        $contactadmins = Contactadmin::findOrFail($id);
       // dd($contactadmins);
        return view('controlpanel.contactadmins.edit', compact('contactadmins'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'address' => 'required',
            'email' => 'required',
            'telephone' => 'required',
        ]);

        $contactadmins = Contactadmin::findOrFail($id);
        $contactadmins->update([
            'address' => $request->address,
            'email' => $request->email,
            'telephone' => $request->telephone,
        ]);

        return redirect()->route('control_panel_dashboard.contactadmins.index')->with('success', 'Successfully updated');
    }

    public function destroy($id)
    {
        $contactadmins = Contactadmin::findOrFail($id);
        $contactadmins->delete();

        return redirect()->route('control_panel_dashboard.contactadmins.index')->with('success', 'Deleted successfully');
    }

    public function show($id)
    {
        $contactadmin = Contactadmin::findOrFail($id);
        return view('controlpanel.contactadmins.show', compact('contactadmin'));
    }
}
