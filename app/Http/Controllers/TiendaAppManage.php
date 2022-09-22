<?php
namespace App\Http\Controllers;

use App\Models\User;
use Dymantic\InstagramFeed\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use TiendaNube\API;
use TiendaNube\Auth as Tauth;

class TiendaAppManage extends Controller
{
    public function auth(Request $request)
    {
        $code = $request->input('code');
        $auth = new Tauth(Config::get('tienda.client_id'), Config::get('tienda.client_secret'));
        $store_info = $auth->request_access_token($code);
        $store_id = $store_info['store_id'] ;
        //Create or edit existing store with the provided access token
        $store = User::where('store_id', $store_id)->first();
        if ($store == null) {
            $store = new User();
            $store->store_Id = $store_id;
        }
        $store->password = $store_info['access_token'];
        $store->email = '';
        $store->save();
        $this->add_scripts($store_id, $store->password);
        //Login and redirect to homepage
        Auth::login($store);

        return Redirect::to('/view');
    }

    public function save_settings(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string',
            'feed_count' => 'required|int'
        ]);
        $id = Auth::user()->store_id;
        $user = User::where('store_id', $id)->update(['feed_count' => $request->input('feed_count'), 'page_url' => $request->input('urls')]);

        $profile = Profile::where('store_id', $id)->first();

        if ($profile == null) {
            $profile = Profile::Create([
                'username' => $request->input('username'),
                'store_id' => $id
            ]);
        } else {
            $profile->Update([
                'username' => $request->input('username'),
            ]);
        }

        return view('instagram-auth-page', ['instagram_auth_url' => $profile->getInstagramAuthUrl()]);
    }

    public function add_scripts($store_id, $access_token)
    {
        if (!is_null($store_id) && !is_null($access_token)) {
            $api = new API($store_id, $access_token, 'Instrafeed (contact@creativeoneone.com)');
            $api->post(
                'scripts',
                [
                    'src' => URL::asset(Config::get('tienda.script_tag'), true),
                    'event' => 'onload',
                    'where' => 'store',
                ]
            );
        }
    }

    public function verify_user()
    {
        $verify = 'https://www.tiendanube.com/apps/' . Config::get('tienda.client_id') . '/authorize';

        return Redirect::to($verify); //redirect to @$this->auth with code
    }

    public function display_settings(Request $request)
    {
        $user = Auth::user();
        $insta = Profile::where('store_id', $user->store_id)->first();
        return view('app.settings', ['user' => $user, 'insta' => $insta]);
    }

    public function send_settings($id)
    {
        $settings = User::where('store_id', $id)->pluck('page_url', 'feed_count')->toArray();
        $feed_count = key($settings);
        $page_url = $settings[$feed_count];
        $username = Profile::where('store_id', $id)->pluck('username')->toArray();
        if (is_array($username) && array_key_exists(0, (array)$username)) {
            $username = $username[0];
            $feed = Profile::where('store_id', $id)->first()->feed();

            return json_encode(['feed_count' => $feed_count, 'username' => $username, 'page_url' => $page_url, 'feeds' => $feed]);
        }

        return null;
    }
}
