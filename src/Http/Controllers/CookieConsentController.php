<?php

namespace w01ki3\CookieConsent\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use w01ki3\CookieConsent\Models\CookieConsentLog;

class CookieConsentController extends Controller
{
    public function scriptUtils(Request $request)
    {
        $script = <<<JS
        window.onload = function() {
            // console.log('Hi');
        };
        JS;

        return response($script, 200)->header('Content-Type', 'application/javascript');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'action' => 'required|string',
            'preferences' => 'nullable|array',
            'url' => 'nullable|string',
        ]);

        CookieConsentLog::create([
            'ip_address' => $this->maskIp($request->ip()),
            'user_agent' => $request->userAgent(),
            'action' => $validated['action'],
            'preferences' => $validated['preferences'],
            'url' => $validated['url'],
        ]);

        return response()->json(['status' => 'success']);
    }

    protected function maskIp(?string $ip): ?string
    {
        if (!$ip) {
            return null;
        }

        $addr = @inet_pton($ip);
        if ($addr === false) {
            return $ip;
        }

        if (strlen($addr) === 4) {
            return preg_replace('/\.\d+$/', '.***', $ip);
        } elseif (strlen($addr) === 16) {
            return inet_ntop($addr & "\xff\xff\xff\xff\xff\xff\xff\xff\x00\x00\x00\x00\x00\x00\x00\x00");
        }

        return $ip;
    }
}
