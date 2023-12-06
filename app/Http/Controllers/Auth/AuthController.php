<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Log;

class AuthController extends Controller
{
	protected static function logWarning($s) : void
	{
		self::log($s, 'warning');
	}

	protected static function log($s, string $level = 'info') : void
	{
		Log::channel('auth')->$level(json_encode(array_merge($s, ['ip' => request()->ip()])));
	}
}
