<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
@auth
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor">
            @tenant
                <a href="#" class="link" data-toggle="tooltip" title="Sair">
                    <i class="mdi mdi-power"></i>
                </a>
            @endtenant
            {{ optional(request()->tenant())->name ?: auth()->user()->name }}
            </h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Plano</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
        <div class="col-md-7 col-4 align-self-center">
            <div class="d-flex m-t-10 justify-content-end">
                <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                    <div class="chart-text m-r-10">
                        <h6 class="m-b-0"><small>PLANO</small></h6>
                        <h4 class="m-t-0 text-info">
                            <a href="{{ route('plans.pricing') }}">Assinar</a>
                        </h4>
                    </div>
                </div>

                <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                    <div class="chart-text m-r-10">
                        <h6 class="m-b-0"><small>EMPRESAS</small></h6>
                        <h4 class="m-t-0 text-info"><a href="{{ route('companies_user.index') }}">01/05</a></h4>
                    </div>
                </div>
                
                <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                    <div class="chart-text m-r-10">
                        <h6 class="m-b-0"><small>LAST MONTH</small></h6>
                        <h4 class="m-t-0 text-primary">$48,356</h4></div>
                    <div class="spark-chart">
                        <div id="lastmonthchart"></div>
                    </div>
                </div>
                <div class="">
                    <button class="right-side-toggle waves-effect waves-light btn-success btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                </div>
            </div>
        </div>        
    </div>
@endauth
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->