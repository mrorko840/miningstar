<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function profile()
    {
        $pageTitle = "Profile Setting";
        $user = auth()->user();
        return view($this->activeTemplate . 'user.profile_setting', compact('pageTitle', 'user'));
    }

    // public function submitProfile(Request $request)
    // {
    //     $request->validate([
    //         'firstname' => 'required|string',
    //         'lastname' => 'required|string',
    //     ], [
    //         'firstname.required' => 'First name field is required',
    //         'lastname.required' => 'Last name field is required'
    //     ]);

    //     $user = auth()->user();

    //     $user->firstname = $request->firstname;
    //     $user->lastname = $request->lastname;

    //     $user->address = [
    //         'address' => $request->address,
    //         'state' => $request->state,
    //         'zip' => $request->zip,
    //         'country' => @$user->address->country,
    //         'city' => $request->city,
    //     ];

    //     $user->save();
    //     $notify[] = ['success', 'Profile updated successfully'];
    //     return back()->withNotify($notify);
    // }
    public function submitProfile(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50'
            
        ],[
            'firstname.required'=>'First Name Field is required',
            'lastname.required'=>'Last Name Field is required'
        ]);


        $in['firstname'] = $request->firstname;
        $in['lastname'] = $request->lastname;


        $user = auth()->user();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = rand(10000000,40000000) . '_' . $user->username.'.png';
            $location = 'assets/images/user/profile/'.$filename;
            $path = './assets/images/user/profile/';
            $link = $path . $user->image;
            if (file_exists($link)) {
                unlink($link);
            }
            $image = Image::make($image);
            $image->resize(200, 200);
            $image->save($location);
            $user->image = $filename;

        }
        $user->address = [
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => @$user->address->country,
            'city' => $request->city,
        ];

        $user->save();
        $notify[] = ['success', 'Profile Updated successfully.'];
        return back()->withNotify($notify);
    }

    public function submitBio(Request $request)
    {
        $user = auth()->user();
        $user->bio = $request->bio;
        $user->save();
        $notify[] = ['success', 'Bio Updated successfully.'];
        return back()->withNotify($notify);
    }

    public function changePassword()
    {
        $pageTitle = 'Change Password';
        return view($this->activeTemplate . 'user.password', compact('pageTitle'));
    }

    public function submitPassword(Request $request)
    {

        $passwordValidation = Password::min(6);
        $general = gs();
        if ($general->secure_password) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $this->validate($request, [
            'current_password' => 'required',
            'password' => ['required', 'confirmed', $passwordValidation]
        ]);

        $user = auth()->user();
        if (Hash::check($request->current_password, $user->password)) {
            $password = Hash::make($request->password);
            $user->password = $password;
            $user->save();
            $notify[] = ['success', 'Password changes successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'The password doesn\'t match!'];
            return back()->withNotify($notify);
        }
    }
}
