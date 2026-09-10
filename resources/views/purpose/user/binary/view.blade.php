<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed " dir="ltr"
    data-template="vertical-menu-template">

<head>
<meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
       

    <title>stake binary</title>


     <!-- Binary trading JS -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     
</head>

<body>

    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <x-danger-alert />
        <x-success-alert />
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-5 row">
                            <div class="shadow-lg col-lg-12 card p-lg-3 p-sm-5">
                                <h2 class="">{{ $settings->site_name }} Smart trader</h2>
                                <div clas="well">
                                    <p class="text-justify ">Predict if an asset will trade higher or lower after a selected period of time.<br>
                                        If you select "high", you win the payout if the exit spot is strictly higher than the entry spot.<br>
                                        If you select "low", you win the payout if the exit spot is strictly lower than the entry spot.<br>
                                        <small>Terms and Conditions apply</small><br>
                                    </p>
                                </div>
                                <br>
                                
                            </div>
                            <div class="shadow-lg col-lg-12 card p-lg-3 p-sm-5">
                               
                                
                                <div class="row asset">
                                    <div class="col-lg-2 col-md-2 col-sm-6">
                                        <span id="stock-price"></span>
                                        <span id="asset-symbol" asset-data="btcusdt"></span>
                                    </div>

                                    <div class="col-lg-2 col-md-2 col-sm-6">
                                        <select id="symbolSelect" onchange="changeSymbol(this.value)">
                                        <option value="BINANCE:BTCUSDT">BTC</option>
                                        <option value="BINANCE:ETHUSDT">ETH</option>
                                        <option value="BINANCE:XRPUSDT">XRP</option>
                                        <option value="BINANCE:BNBUSDT">BNB</option>
                                        <option value="BINANCE:LTCUSDT">LTC</option>
                                            <!-- Add more crypto assets here -->
                                        </select>
                                    </div>
                                </div>

                                <!-- TradingView Widget BEGIN -->
                                <div class="tradingview-widget-container">
                                <script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
                                <div id="tradingview_e024d"></div>
                                
                                </div><br>
                                <!-- TradingView Widget END -->

                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="text-center">

                                        <form id="stakeForm" role="form" method="post" action="javascript:void(0)">

                                            @csrf

                                            <div class="form-group">
                                                <label for="amount">Amount:</label>
                                                <input type="number" class="form-control" name="amount" id="amount" required>
                                                <label for="payout">Payout: 162 USD</label> 
                                            </div><br>

                                            <div class="form-group">
                                                <label for="duration">Duration:</label>
                                                <select class="form-control" name="duration" id="duration" required>
                                                <option value="2">2 Minutes</option>
                                                <option value="5">5 Minutes</option>
                                                <option value="15">15 Minutes</option>
                                                <option value="30">30 Minutes</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <input type="hidden" name="action" id="actionInput">
                                            <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
                                            <label class="stake">Stake &nbsp;<i class="fa fa-line-chart"></i></label><br>
                                                <button type="submit" value="higher" onclick="setActionValue(this)" class="btn btn-success bt-cstm">Higher</button>
                                                <button type="submit" value="lower" onclick="setActionValue(this)" class="btn btn-danger bt-cstm">Lower</button>
                                            </div>
                                        </form>

                                        <script>

                                        function setActionValue(button) {
                                            var actionInput = document.getElementById("actionInput");
                                            actionInput.value = button.value;
                                        }
                                        
                                        $("#stakeForm").on("submit", function (event) {
                                                event.preventDefault();

                                                var url = "{{ route('binarystake') }}";
                                                var form = this;
                                                formData = new FormData(form);
                                                formData.append('_method', 'POST');
                                                console.log(Array.from(formData));

                                                $.ajaxSetup({
                                                    headers: {
                                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                                    }
                                                });

                                                $.ajax({
                                                    method: "POST",
                                                    url: url,
                                                    data:formData,
                                                    cache: false,
                                                    contentType: false,
                                                    processData: false,
                                                    success: function (response) {
                                                        console.log(response);
                                                    },
                                                    error: function (xhr, status, error) {
                                                        console.log(xhr.responseText);
                                                        console.log(status);
                                                        console.log(error);
                                                    }
                                                });
                                            });
                                        </script>


                                    </div>
                                </div>

                            </div>

                        </div>
                        
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
    
 
</body>

</html>
