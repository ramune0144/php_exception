<?php
// app/Http/Middleware/CheckPhpExtension.php

namespace App\Http\Middleware;

use Closure;

class CheckPhpExtension
{
    public function handle($request, Closure $next)
    {
        // Check if ".php" is present in the URL
        if (strpos($request->getRequestUri(), '.php') !== false || strpos($request->getRequestUri(), '.js') !== false || strpos($request->filename, '.php') !== false) {
            // If ".php" is found, you can handle it as needed
            // For example, you might want to abort the request
            abort(403, 'Access denied.');
        }

        if ($request->upload) {

            foreach ($request->upload as $file) {
                $allowedExtensions = ['jpeg', 'jpg', 'png', 'pdf', 'docx', 'gif'];
                $uploadedExtension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
                // if (strpos($file->getClientOriginalName(), '.php') !== false) {
                //     // If ".php" is found, you can handle it as needed
                //     // For example, you might want to abort the request
                //     abort(403, 'Access denied.');
                // }
                if (!in_array(strtolower($uploadedExtension), $allowedExtensions)) {

                    abort(403, 'Access denied.');
                }
            }
        }
        // else echo "console.log('no filename')";
        return $next($request);
    }
}
