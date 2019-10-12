@auth
    <div class="dropdown-menu animated flipInY">
        @if($companies->count())
            @foreach($companies as $company)
                <a class="dropdown-item" href="{{ route('tenant.switch', $company) }}">
                    {{ $company->name }}
                </a>
            @endforeach
            <div class="dropdown-divider"></div>
        @endif
        <a class="dropdown-item" href="{{ route('companies.create') }}">Nova Empresa</a>
    </div>
@endauth