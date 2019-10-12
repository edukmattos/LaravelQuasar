<div class="form-group m-b-40 {{ $errors->has('name') ? ' has-danger' : '' }} focused">
    <label for="name">@lang('translate.CompanyName')</label>
    <input 
        type="text" 
        class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" 
        name="name" 
        value="{{ old('name') }}" 
        autofocus 
        id="name">
    <span class="bar"></span>
    @if ($errors->has('name'))
        <span class="invalid-feedback">
            <strong>{{ $errors->first('name') }}</strong>
        </span>
    @endif
</div>

<div class="form-group m-b-40 {{ $errors->has('einssa') ? ' has-danger' : '' }}">
    <label for="einssa">@lang('translate.CompanyEinSsa')</label>
    <input 
        type="text" 
        class="form-control{{ $errors->has('einssa') ? ' is-invalid' : '' }}" 
        name="einssa" 
        value="{{ old('einssa') }}" 
        id="einssa">
    <span class="bar"></span>
    @if ($errors->has('einssa'))
        <span class="invalid-feedback">
            <strong>{{ $errors->first('einssa') }}</strong>
        </span>
    @endif
</div>

<div class="form-group m-b-40 {{ $errors->has('business_type_id') ? ' has-danger' : '' }}">
    <label for="business_type_id">@lang('translate.BusinessType')</label>
        <select 
            class="form-control {{ $errors->has('business_type_id') ? ' is-invalid' : '' }}" 
            name="business_type_id"
            value="{{ old('business_type_id') }}"
            id="business_types_options"
            placeholder="ditige ..."
            data-url="{{ route('businessTypes.autocomplete') }}"
            data-noresults-text="Nothing to see here."
            autocomplete="off">
            @foreach($business_types as $key => $value)
                <option value={{ $key }}>{{ $value }}</option>
            @endforeach
        </select>
    <span class="bar"></span>
    @if ($errors->has('business_type_id'))
        <span class="invalid-feedback">
            <strong>{{ $errors->first('business_type_id') }}</strong>
        </span>
    @endif
</div>


