@extends('layouts.app')
@section('content')
    <div class="mt-2 mb-4">
        <h1 class="title1">Send Email to users</h1>
    </div>
    <x-admin.alert />
    <div class="mb-5 row">
        <div class="col-md-12">
            <div class="card p-2 shadow ">
                <div class="card-body">
                    <form method="post" action="{{ route('sendmailtoall') }}">
                        @csrf
                        <div class="form-group">
                            <h6 class="">Category</h6>
                            <select class="form-control" id="userCategory" name="category">
                                <option value="All">All Users</option>
                                <option value="No active plans">Users without investment plan</option>
                                <option value="No deposit">Users without any Deposit (likely to be new users)
                                </option>
                                <option value="Select Users">Choose Users</option>
                            </select>
                        </div>
                        <div class="form-group d-none" id="select-user-view">
                            <h6 class="">Select Users (<span class="text-primary font-bold" id="numofusers">0</span>)
                            </h6>
                            <select onChange="SelectPage(this)" name="users[]" multiple class="form-control select2"
                                style="width: 100%" id="showusers"></select>
                            <div id="loader" class="mt-1">
                                <div class="spinner-border spinner-border-sm" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <span>Loading your users, please wait</span>
                            </div>

                        </div>
                        <div class=" form-group">
                            <h6 class="">Greeting/Title</h6>
                            <div class="input-group">
                                <input type="text" aria-label="Hello" value="Hello" name="greet" class="form-control">
                                <input type="text" aria-label="Investor" value="Investor" name="title"
                                    class="form-control">
                            </div>
                        </div>
                        <div class=" form-group">
                            <h6 class="">Subject</h6>
                            <input type="text" name="subject" class="form-control  " placeholder="Subject" required>
                        </div>
                        <div class=" form-group">
                            <textarea placeholder="Type your message here" class="form-control ckeditor" name="message" row="8"
                                placeholder="Type your message here" required></textarea>
                        </div>
                        <div class=" form-group">
                            <button type="submit" class="btn btn-secondary">
                                <span>Send</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="//cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.ckeditor').ckeditor();
        });
    </script>
    <script>
        var category = document.querySelector("#userCategory")
        var loader = document.querySelector("#loader")
        if (category.value == "Select Users") {
            document.querySelector("#select-user-view").classList.remove("d-none")
        } else {
            document.querySelector("#select-user-view").classList.add("d-none")
        }

        function SelectPage(elem) {
            var options = elem.options
            var count = 0
            for (var i = 0; i < options.length; i++) {
                if (options[i].selected) count++;
            }
            document.querySelector("#numofusers").textContent = count;
        }
        $('.select2').select2();
        var users = document.querySelector('#showusers')
        fetch("{{ route('fetchusers') }}")
            .then(response => response.json())
            .then(data => {
                loader.classList.add("d-none")
                data.data.forEach(element => {
                    var usersopt = document.createElement('option');
                    usersopt.value = element.id;
                    usersopt.innerHTML = element.name;
                    users.appendChild(usersopt);
                });
            });

        category.addEventListener('change', function() {
            if (category.value == "Select Users") {
                document.querySelector("#select-user-view").classList.remove("d-none")
            } else {
                document.querySelector("#select-user-view").classList.add("d-none")
            }
        })
    </script>
@endpush
