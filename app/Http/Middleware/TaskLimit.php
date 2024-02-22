<?php

namespace App\Http\Middleware;

use App\Models\Task;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskLimit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check that the "user id" that contains the POST request is not repeated more than 5 times in the rows
        $userId = $request->input('user_id');
        $tasks = Task::where('user_id', $userId)->count();

        if ($tasks >= 5) {
            return response()->json(['mensaje' => "It has a limit of 5 tasks. You can't create more."], 403);
        }

        return $next($request);
    }
}
