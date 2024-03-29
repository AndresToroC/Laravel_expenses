<x-error-layout>
    <div class="row flex-grow">
        <div class="col-lg-7 mx-auto text-white">
            <div class="row align-items-center d-flex flex-row">
                <div class="col-lg-6 text-lg-right pr-lg-4">
                    <h1 class="display-1 mb-0">403</h1>
                </div>
                <div class="col-lg-6 error-page-divider text-lg-left pl-lg-4">
                    <h2>Lo sentimos!</h2>
                    <h3 class="font-weight-light">El usuario no tiene los roles adecuados.</h3>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-12 text-center mt-xl-2">
                    <a class="text-white font-weight-medium" href="{{ route('dashboard') }}">Regrasa al inicio</a>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-12 mt-xl-2">
                    <p class="text-white font-weight-medium text-center">Copyright &copy; {{ date('Y') }}  All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
</x-error-layout>