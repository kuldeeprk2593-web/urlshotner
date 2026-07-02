<?php

namespace App\Http\Controllers;
 
use App\Models\ShortUrl;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View; 
use Illuminate\Support\Facades\Cache;  


class ShortUrlController extends Controller
{ 
    public function index(Request $request): View
    {
        $user = $request->user();

        abort_if($user->isSuperAdmin(), 403, 'SuperAdmin cannot view short urls for any company.');

        $query = ShortUrl::query()->with(['user', 'company'])->latest();

        if ($user->isAdmin()) {
            $query->where('company_id', $user->company_id);
        } else { 
            $query->where('user_id', $user->id);
        }

        $shortUrls = $query->paginate(15);

        return view('short_urls.index', compact('shortUrls'));
    }

    public function create(Request $request): View
    {   
        abort_unless($request->user()->canCreateShortUrls(), 403, 'Only Admin and Member users can create short urls.');

        return view('short_urls.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        abort_unless($user->canCreateShortUrls(), 403, 'Only Admin and Member users can create short urls.');

        $data = $request->validate([
            'original_url' => ['required', 'url', 'max:2048'],
        ]);

        $shortUrl = ShortUrl::create([
            'original_url' => $data['original_url'],
            'user_id' => $user->id,
            'company_id' => $user->company_id,
        ]);

        return redirect()
            ->route('short-urls.index')
            ->with('status', 'Short url created: '.route('short-urls.redirect', $shortUrl->code));
    }
 

        public function redirect(string $code): RedirectResponse {
            $shortUrl = Cache::remember(
                'short_url_'.$code,
                now()->addHour(),
                function () use ($code) {  
                    logger('******** first Time hit database ********'); 
                    return ShortUrl::where('code', $code)->firstOrFail();
                }
            ); 
                logger('******** Hit Cache ********');
            return redirect()->away($shortUrl->original_url);
        }

}
