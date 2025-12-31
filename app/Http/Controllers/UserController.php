<?php

namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\User;
use DataTables;
use Illuminate\Validation\Rule;
  
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = User::query();
            return datatables()->of(User::select('id', 'name', 'email'))
            ->addColumn('action', function ($user) {
                return '<button class="btn btn-sm btn-primary editUser" data-id="'.$user->id.'">
                            Edit
                        </button>';
            })
            ->rawColumns(['action'])
            ->make(true);
        }
          
        return view('users');
    }


 // Fetch single user
    public function show(User $user)
    {
        return response()->json($user);
    }

    // Update user
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
        ]);

        $user->update($validated);

        return response()->json([
            'message' => 'User updated successfully!',
        ]);
    }

}  