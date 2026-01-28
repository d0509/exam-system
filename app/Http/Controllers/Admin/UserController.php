<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select('id', 'name', 'email', 'status');
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group">';
                    $btn .= '<a href="' . route('admin.users.show', $row->id) . '" class="btn btn-sm btn-primary"><i class="far fa-eye"></i></a>';
                    $btn .= '<button type="button" class="btn btn-sm btn-danger delete-btn ml-1" data-id="' . $row->id . '"><i class="fas fa-trash"></i></button>';
                    $btn .= '</div>';
                    return $btn;
                })
                ->addColumn('status', function ($row) {

                    $checked = $row->status ? 'checked' : '';
                    $active  = $row->status ? 'btn-success' : 'btn-outline-secondary';

                    return '
                        <div class="form-check form-switch">
                            <input
                                type="checkbox"
                                class="form-check-input user-status-toggle"
                                id="status_' . $row->id . '"
                                data-user-id="' . $row->id . '"
                                ' . $checked . '
                                role="switch"
                            >
                        </div>
                    ';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('admin.pages.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());
        $user->assignRole('student');
        if ($user) {
            return redirect()->route('admin.users.index')->with('success', 'User created successfully');
        }

        return redirect()->route('admin.users.index')->with('error', 'User created failed');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);

        return view('admin.pages.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);

        return view('admin.pages.users.create', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function updateStatus(Request $request)
    {
        $user = User::find($request->user_id);
        if ($user) {
            $user->status = $request->status;
            $user->save();
            return response()->json(['success' => true, 'message' => 'Status updated successfully']);
        }
        return response()->json(['success' => false, 'message' => 'User not found']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
