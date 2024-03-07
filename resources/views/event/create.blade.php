<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap5.min.css">
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Event List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="row">
                        <div class="col-md-12 justify-content-end d-flex mb-2">
                            <a href="{{ route('event.index') }}" class="btn btn-danger">Back</a>
                        </div>
                        <div class="col-md-12">
                            <form action="{{ route('event.store') }}" method="POST" id="event-form">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" class="form-control" name="title" id="title">
                                        <span id="title_error"></span>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea name="description" id="description" class="form-control" rows="2"></textarea>
                                        <span id="description_error"></span>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="date" class="form-label">Date</label>
                                        <input type="date" class="form-control" name="date" id="date">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="time" class="form-label">Time</label>
                                        <input type="time" name="time" class="form-control" id="time">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="venue" class="form-label">Venue</label>
                                        <input type="text" name="venue" class="form-control" id="venue">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="seats" class="form-label">No. Seats</label>
                                        <input type="number" name="seats" class="form-control" id="seats">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="ticket_price" class="form-label">Ticket Price</label>
                                        <input type="number" name="ticket_price" class="form-control" id="ticket_price">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary bg-primary mt-3">Submit</button>
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
<script>

</script>
