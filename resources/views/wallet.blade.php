<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Wallet') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="row">
                        <div class="col-md-6">
                            <b>Total Balance :</b> <span>${{ $wallet->wallet }}</span>
                        </div>
                        <div class="col-md-6 justify-content-end d-flex">
                            <button class="btn btn-primary addBalance">Add Balance</button>
                        </div>
                        <div class="col-md-6" id="addBalanceForm" style="display: none;">
                            <form action="{{ route('add.balance') }}" method="POST" id="wallet-form">
                                @csrf
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Amount</label>
                                    <input type="number" class="form-control" name="amount" id="amount">
                                    <span id="amount_error"></span>
                                </div>
                                <button type="submit" class="btn btn-primary bg-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js" integrity="sha512-WMEKGZ7L5LWgaPeJtw9MBM4i5w5OSBlSjTjCtSnvFJGSVD26gE5+Td12qN5pvWXhuWaWcVwF++F7aqu9cvqP0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).on('click', '.addBalance', function() {
        $('#addBalanceForm').show();
        $(this).addClass('removeForm').removeClass('addBalance');
    });

    $(document).on('click', '.removeForm', function() {
        $('#addBalanceForm').hide();
        $(this).addClass('addBalance').removeClass('removeForm');
    });

    $("#wallet-form").validate({
        rules: {
            amount: {
                required: true,
                min: 5
            },
        },
        messages: {
            amount: {
                required: "Please add amount",
                min: "Please add min amount 5.",
            },
        },
        errorPlacement: function(error, element) {
            $("#" + element.attr("name") + "_error").html(error);
        }
    });
</script>
