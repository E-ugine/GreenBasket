<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    // GET /api/user
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $userWithOrders = User::with('orders')->find($user->id);

        return response()->json(['user' => $userWithOrders]);
    }

    // POST /api/login
    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $token = $user->createToken('GreenBasket')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    return response()->json(['error' => 'Invalid credentials'], 401);
}


    // POST /api/register
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->only('name', 'email', 'password');
        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);
        $token = $user->createToken('GreenBasket')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    // GET /api/users/{user}
    public function show(User $user)
    {
        return response()->json($user);
    }

    // GET /api/users/{user}/orders
    public function showOrders(User $user)
    {
        $orders = $user->orders()->with('product')->get();

        return response()->json([
            'user' => $user,
            'orders' => $orders,
        ]);
    }

    // PUT /api/users/{user}
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|max:50',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $input = $request->all();

        if ($request->has('password')) {
            $input['password'] = bcrypt($request->password);
        }

        $user->update($input);

        return response()->json($user);
    }

    // DELETE /api/users/{user}
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
