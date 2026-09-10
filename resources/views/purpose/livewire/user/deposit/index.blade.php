<div>
    <x-danger-alert />
    <x-success-alert />
    <div class="row" x-data>
        @forelse ($depositMethods as $method)
            <div class="col-6 col-xl-3">
                <!-- Card -->
                <a href="" @click.prevent="$wire.set('methodSelected', '{{ $method->name }}')">
                    <div @class([
                        'card',
                        'border border-3 border-primary' => $methodSelected === $method->name,
                    ])>
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div
                                    class="avatar avatar-lg text-bg-gray-300 d-flex align-items-center justify-content-center">
                                    @if (empty($method->img_url))
                                        <svg width="42px" height="37px" viewBox="0 0 1024 1024" class="icon"
                                            version="1.1" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M512 512m-480 0a480 480 0 1 0 960 0 480 480 0 1 0-960 0Z"
                                                fill="#E9E8FF" />
                                            <path
                                                d="M467.2 332.8l230.4-83.2 44.8 83.2zM384 332.8l96-83.2 38.4 51.2-64 32z"
                                                fill="#C6C9FF" />
                                            <path
                                                d="M300.8 755.2c-25.6 0-51.2-25.6-51.2-51.2V384c0-25.6 25.6-51.2 51.2-51.2h428.8c25.6 0 51.2 25.6 51.2 51.2v313.6c0 25.6-25.6 51.2-51.2 51.2l-428.8 6.4z"
                                                fill="#8880FE" />
                                            <path
                                                d="M761.6 608H704c-25.6 0-51.2-19.2-51.2-51.2v-19.2c0-25.6 25.6-51.2 51.2-51.2h57.6c25.6 0 51.2 19.2 51.2 51.2v25.6c0 25.6-19.2 44.8-51.2 44.8z"
                                                fill="#C6C9FF" />
                                        </svg>
                                    @else
                                        <img src="{{ $method->img_url }}" alt="" srcset="" width="42px"
                                            height="37px">
                                    @endif
                                </div>
                            </div>
                            <!-- Title -->
                            <h3 class="card-title mt-3 mb-0 text-dark">{{ $method->name }}</h3>
                            <span class="text-muted m-0 p-0">Pay via {{ strtolower($method->name) }}</span>
                        </div>
                    </div>
                </a>
            </div>
        @empty
        @endforelse
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <h1 class="m-0 p-0">
                {{ $methodSelected }}
            </h1>
            <span class="badge rounded-pill text-bg-primary m-0">selected</span>
        </div>

        <div class="col-lg-8 mt-3">
            <p class="m-0">Select an amount</p>
            <div class="row mt-2">
                <div class="col-lg-4 col-3">
                    <a href="" wire:click.prevent="setAmount(100)">
                        <div class="card text-center py-2 fw-bold">
                            {{ $settings->currency }} 100
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-3">
                    <a href="" wire:click.prevent="setAmount(200)">
                        <div class="card text-center py-2 fw-bold">
                            {{ $settings->currency }} 200
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-3">
                    <a href="" wire:click.prevent="setAmount(400)">
                        <div class="card text-center py-2 fw-bold">
                            {{ $settings->currency }} 400
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-3">
                    <a href="" wire:click.prevent="setAmount(500)">
                        <div class="card text-center py-2 fw-bold">
                            {{ $settings->currency }} 500
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-3">
                    <a href="" wire:click.prevent="setAmount(800)">
                        <div class="card text-center py-2 fw-bold">
                            {{ $settings->currency }} 800
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-3">
                    <a href="" wire:click.prevent="setAmount(1000)">
                        <div class="card text-center py-2 fw-bold">
                            {{ $settings->currency }} 1000
                        </div>
                    </a>
                </div>
                <div class="col-lg-12 mt-2">
                    <label class="visually-hidden" for="inlineFormInputGroupUsername">Enter amount</label>
                    <form action="{{ route('newdeposit') }}" method="POST"
                        class="row row-cols-lg-auto g-3 align-items-center">
                        @csrf
                        <div class="col-12">
                            <input class="form-control w-100" placeholder="Enter Amount"
                                min="{{ $moresettings->minamt }}" type="number" step="any" name="amount"
                                wire:model.defer='amount' value="{{ $amount }}" required>
                            <input type="hidden" name="payment_method" value="{{ $methodSelected }}"
                                wire:model='methodSelected' id="paymethod">
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary">
                                Proceed
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
