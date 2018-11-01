<?php

namespace Docs;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
	protected $namespace = 'Docs';
	
	public function map()
	{
		$files = File::glob(__DIR__.'/views/*.blade.php');
		
		foreach ($files as $filename) {
			$view = basename($filename, '.blade.php');
			
			// Skip partials
			if (0 === strpos($view, '_')) {
				continue;
			}
			
			$path = 'index' === $view
				? '/'
				: $view;
			
			Route::get($path, function() use ($view, $path) {
				return view($view, [
					'current_path' => $path,
					'readme' => new Readme(),
				]);
			});
		}
	}
}
