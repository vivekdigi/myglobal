<?php

namespace App\Http\Livewire\Admin;

use App\Models\Settings;
use App\Models\Theme;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;
use Livewire\Component;
use Livewire\WithFileUploads;

class ThemeDisplay extends Component
{
    use WithFileUploads;
    public $theme;
    public bool $uploadTheme = false;

    public function render()
    {
        return view('livewire.admin.theme-display');
    }

    public function setTheme($theme)
    {

        Settings::where('id', '1')
            ->update([
                'website_theme' => $theme,
            ]);
    }

    public function uploadTheme(): void
    {
        $this->uploadTheme = true;
    }

    public function cancelUpload(): void
    {
        $this->uploadTheme = false;
    }


    protected $rules = [
        'theme' => ['max:30000'],
    ];

    public function saveTheme()
    {
        $settings = Settings::find(1);
        $this->validate();
        sleep(4);

        if ($this->theme->extension() != 'zip') {
            session()->flash('error', 'Please upload a zip file');
        } else {

            // read the content of the zip file
            $zip = new \ZipArchive();
            $open = $zip->open($this->theme->getRealPath());

            //get theme name without the .zip extension
            $themeName = substr($this->theme->getClientOriginalName(), 0, -4);

            if ($open === TRUE) {
                // extract the zip file to the themes folder
                $zip->extractTo(base_path("themes/{$themeName}"));
                //$zip->extractTo(public_path("themes/{$themeName}"));
                $zip->close();

                //extract the views file to the resources folder
                $zip->open(base_path("themes/{$themeName}/views.zip"));
                //$zip->open(public_path("themes/{$themeName}/views.zip"));
                $zip->extractTo(resource_path("views"));
                $zip->close();

                // add the theme to the database
                $settings->theme = $themeName;
                $settings->save();

                // reset the upload form
                $this->theme = null;
                session()->flash('success', 'Theme uploaded successfully');
            } else {
                session()->flash('error', 'There was an error uploading the theme, please try again.');
            }
        }
        return redirect()->route('appsettingshow');
    }

    //chose theme
    public function chooseTheme(int $id)
    {
        //set the active theme, only one theme can be active at a time
        Theme::where('active', true)->update(['active' => false]);
        Theme::where('id', $id)->update(['active' => 1]);
        session()->flash('success', 'Theme activated successfully');
    }

    //clear cache files and views
    public function clearCache()
    {
        //clear the cache with Artisan command
        Artisan::call('cache:clear');
        Artisan::call('view:clear');

        session()->flash('success', 'Cache cleared successfully');
        return redirect()->route('appsettingshow');
    }
}
