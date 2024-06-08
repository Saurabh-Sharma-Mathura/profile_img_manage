<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
  
    public function update(Request $request)
    {
        $user = Auth::user();

        $data = $request->all();

        $validator = Validator::make($data, [
            'first_name' => ['required', 'string', 'max:50', 'regex:/^[A-Za-z]+$/'],
            'last_name' => ['nullable', 'string', 'max:50', 'regex:/^[A-Za-z]+$/'],
            'email' => ['required', 'string', 'email', 'max:50', 'unique:users,email,'.$user->id],
            'mobile_number' => ['required', 'string', 'size:10', 'unique:users,mobile_number,'.$user->id],
            'date_of_birth' => ['required', 'date'],
            'gender' => ['required', 'string'],
            'address' => ['nullable', 'string', 'max:200'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png','min:100','max:1024']
        ]);

        if ($validator->fails()) {
            return redirect()->route('dashboard')
                ->withErrors($validator)
                ->withInput();
        }

        if (isset($data['profile_image'])) {
            $path = $data['profile_image']->store('profile_images', 'public');
            $user->profile_image = $path;
        }




        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->email = $data['email'];
        $user->mobile_number = $data['mobile_number'];
        $user->date_of_birth = $data['date_of_birth'];
        $user->gender = $data['gender'];
        $user->address = $data['address'];
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Profile updated successfully.');
    }
}
