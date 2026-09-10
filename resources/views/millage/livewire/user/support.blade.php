<div>
    <x-danger-alert />
    <x-success-alert />
    <!-- Card -->
    <div class="card border-0">
        <div class="card-body py-7">
            <div class="row justify-content-center">
                <div class="col-lg-4">
                    <input type="text" wire:model='search'
                        class="form-control form-control-lg border-2 border-primary rounded-pill mb-4"
                        placeholder="Write a question or problem">
                </div>
            </div> <!-- / .row -->

            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-6 text-center mb-7">
                    <a href="javascript: void(0);" class="badge fs-5 text-bg-gray-300 py-2 px-3 m-2 mb-1">How secure is
                        your
                        Payment method?</a>
                    <a href="javascript: void(0);" class="badge fs-5 text-bg-gray-300 py-2 px-3 m-2 mb-1">How secure is
                        my
                        data?</a>
                    <a href="javascript: void(0);" class="badge fs-5 text-bg-gray-300 py-2 px-3 m-2 mb-1">How can I
                        upgrade
                        my plan?</a>
                    <a href="javascript: void(0);" class="badge fs-5 text-bg-gray-300 py-2 px-3 m-2 mb-1">How do I know
                        I
                        have the latest version?</a>
                    <a href="javascript: void(0);" class="badge fs-5 text-bg-gray-300 py-2 px-3 m-2 mb-1">Can I invite
                        others?</a>
                    <a href="javascript: void(0);" class="badge fs-5 text-bg-gray-300 py-2 px-3 m-2 mb-1">Where do I
                        find my
                        Profit history?</a>
                </div>
            </div> <!-- / .row -->

            <div class="row justify-content-center">
                <div class="col-lg-10 col-xxl-9">
                    <h2 class="h3 text-center">Frequently Asked Questions</h2>

                    <div class="row mb-6">
                        @forelse ($faqs as $faq)
                            <div class="col-xl-6">
                                <div class="d-flex mb-6">
                                    <div class="text-primary me-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="20"
                                            width="20">
                                            <path
                                                d="M12,0A12,12,0,1,0,24,12,12,12,0,0,0,12,0Zm0,19a1.5,1.5,0,1,1,1.5-1.5A1.5,1.5,0,0,1,12,19Zm1.6-6.08a1,1,0,0,0-.6.92,1,1,0,0,1-2,0,3,3,0,0,1,1.8-2.75A2,2,0,1,0,10,9.25a1,1,0,0,1-2,0,4,4,0,1,1,5.6,3.67Z"
                                                style="fill: currentColor" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="h4 mb-0">{{ $faq->question }}</h3>
                                        <p class="mb-0">{{ $faq->answer }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="py-4 col-12">
                                <h2 class="h4 text-center">No FAQs at the moment.</h2>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div
                    class="d-flex align-items-end bg-primary rounded text-center pt-6 px-4 position-relative min-h-200px">
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <h4 class="h3 text-white">Can't find what you're looking for?</h4>

                        <!-- Link -->
                        <a class="btn btn-lg btn-white link-primary"
                            href="mailto:{{ $settings->contact_email }}">Contact Us</a>
                    </div>
                    <img src="https://d33wubrfki0l68.cloudfront.net/3b17577d9510ca8e973cf1ec6558bb69279745e7/40233/assets/images/illustrations/faq-illustration.svg"
                        class="img-fluid ms-auto d-none d-md-block" alt="..." width="150" height="150">
                </div>
            </div>
        </div> <!-- / .row -->
    </div>
</div>
</div>
