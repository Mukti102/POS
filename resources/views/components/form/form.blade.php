@props(['title' => 'sss', 'subtitle' => 'ssss', 'route' => 'dashboard', 'action' => '', 'method' => null])
<form action="{{ $route }}" method="POST" class="card" enctype="multipart/form-data">
    @csrf
    @isset($method)
        @method($method)
    @endisset
    <div class="card-body">
        <div class="row">
            {{ $slot }}
            <div class="col-lg-12">
                <button type="submit" class="btn btn-submit me-2">Submit</button>
                <a href="{{ url()->previous() }}" class="btn btn-cancel">Cancel</a>
            </div>

        </div>
    </div>
</form>
