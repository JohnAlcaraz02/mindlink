<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function index()
    {
        return view('journal.index');
    }

    public function create()
    {
        return view('journal.create');
    }

    public function store(Request $request)
    {
        // TODO: Implement journal entry storage
        return redirect()->route('journal.index')
            ->with('success', 'Journal entry created successfully!');
    }

    public function show($id)
    {
        return view('journal.show');
    }

    public function edit($id)
    {
        return view('journal.edit');
    }

    public function update(Request $request, $id)
    {
        // TODO: Implement journal entry update
        return redirect()->route('journal.index')
            ->with('success', 'Journal entry updated successfully!');
    }

    public function destroy($id)
    {
        // TODO: Implement journal entry deletion
        return redirect()->route('journal.index')
            ->with('success', 'Journal entry deleted successfully!');
    }
}