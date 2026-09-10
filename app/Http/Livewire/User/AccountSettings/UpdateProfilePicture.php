<?php

namespace App\Http\Livewire\User\AccountSettings;

use App\Models\Settings;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateProfilePicture extends Component
{
    public $photo;
    public $photoPath;

    use WithFileUploads;

    public function mount()
    {
        $this->photoPath = auth()->user()->profile_photo_path;
    }
    public function render()
    {
        $settings = Settings::select('theme')->find(1);
        return view("{$settings->theme}.livewire.user.account-settings.update-profile-picture");
    }

    public function update()
    {
        Log::info("Your profile picture");
        $this->validate([
            'photo' => ['required', 'image', 'max:1024', 'mimes:jpg,jpeg,png'],
        ]);

        $user = User::find(auth()->user()->id);
        $user->profile_photo_path = $this->photo->store('profile-photos', 'public');
        $user->save();

        $this->photoPath = $user->profile_photo_path;
        $this->dispatchBrowserEvent('profile-updated', ['message' => 'Your profile picture is updated successfully.', 'type' => 'success']);
    }
}
