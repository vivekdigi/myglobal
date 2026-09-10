<?php

namespace App\Http\Livewire\Admin\Platform;

use App\Models\Settings;
use Illuminate\Support\Facades\Artisan;
use Livewire\Component;

class Caches extends Component
{
    public $viewCached;
    public $routeCached;
    public $configCached;

    public function mount()
    {
        $settings = Settings::first();
        $this->viewCached = $settings->view_cached;
        $this->routeCached = $settings->route_cached;
        $this->configCached = $settings->config_cached;
    }

    public function render()
    {
        return view('livewire.admin.platform.caches');
    }

    public function clearCompiledViews()
    {
        Artisan::call('view:clear');
        $settings = Settings::find(1);
        $settings->view_cached = false;
        $settings->save();
        session()->flash('success', 'Compiled views cleared.');
        return redirect()->route('aboutonlinetrade');
    }

    public function cacheViews()
    {
        Artisan::call('view:cache');
        $settings = Settings::find(1);
        $settings->view_cached = true;
        $settings->save();
        session()->flash('success', 'Views cached.');
        return redirect()->route('aboutonlinetrade');
    }

    public function clearRouteCache()
    {
        Artisan::call('route:clear');
        $settings = Settings::find(1);
        $settings->route_cached = false;
        $settings->save();
        session()->flash('success', 'Route cache cleared.');
        return redirect()->route('aboutonlinetrade');
    }

    public function clearCache()
    {
        Artisan::call('cache:clear');
        session()->flash('success', 'Cache cleared successfully.');
        $this->redirect('/admin/dashboard/platform');
    }

    public function cacheRoutes()
    {
        Artisan::call('route:cache');
        $settings = Settings::find(1);
        $settings->route_cached = true;
        $settings->save();
        session()->flash('success', 'Routes cached.');
        return redirect()->route('aboutonlinetrade');
    }

    public function clearConfigCache()
    {
        Artisan::call('config:clear');
        $settings = Settings::find(1);
        $settings->config_cached = false;
        $settings->save();
        session()->flash('success', 'Config cache cleared.');
        return redirect()->route('aboutonlinetrade');
    }

    public function cacheConfig()
    {
        Artisan::call('config:cache');
        $settings = Settings::find(1);
        $settings->config_cached = true;
        $settings->save();
        session()->flash('success', 'Config cached.');
        return redirect()->route('aboutonlinetrade');
    }
}
