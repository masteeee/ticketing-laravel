public function handle($request, Closure $next)
{
    if ($request->ajax() || $request->expectsJson()) {
        // Jangan simpan URL ini untuk redirect setelah login
        session()->forget('url.intended');
    }

    return $next($request);
}
