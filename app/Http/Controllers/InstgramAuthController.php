<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InstgramAuthController extends Controller
{
    //
	//in InsatgramAuthController.php
	public function show() {
		$profile = \Dymantic\InstagramFeed\Profile::where('username', 'apurbapodder')->first();
		return view('instagram-auth-page', ['instagram_auth_url' => $profile->getInstagramAuthUrl()]);
	}

	//InstagramAuthController.php
	public function complete() {
		$was_successful = request('result') === 'success';

		return view('instagram-auth-response-page', ['was_successful' => $was_successful]);
	}

}
