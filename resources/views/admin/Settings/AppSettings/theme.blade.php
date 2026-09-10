 <div class="row">
     <div class="col-lg-6">
         <form method="post" action="{{ route('theme.update') }}" enctype="multipart/form-data" id="themeForm">
             @csrf
             <div class="form-row">
                 <div class="form-group col-12">
                     <label>Upload new User dashboard Theme (zip file)</label>
                     <input type="file" name='theme' class="form-control" required>
                     @error('theme')
                         <span class="text-danger d-block mt-2">{{ $message }}</span>
                     @enderror
                     @if (session()->has('error'))
                         <span class="text-danger d-block mt-2">{{ session('error') }}</span>
                     @endif
                 </div>
                 <div class="form-group col-12">
                     <button type="submit" class="px-4 btn btn-primary btn-sm" id="themeBtn">Save</button>
                 </div>
             </div>
         </form>
         <div class="mt-2 d-none" id="loadingTheme">
             <progress max="100"></progress>
             <p>Please wait while the theme is being uploaded, do not refresh this...</p>
         </div>
     </div>
     <div class="col-lg-6">
         <livewire:admin.choose-theme>
     </div>
 </div>
 <livewire:admin.theme-display />
