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
        {!! Form::select('business_type_id', $business_types, $value = null, ['id'=>'business_types_list', 'class'=>"form-control {{ $errors->has('business_type_id') ? ' is-invalid' : '' }} select2"]) !!}
        <select 
            class="form-control {{ $errors->has('business_type_id') ? ' is-invalid' : '' }}" 
            style="width: 100%"
            name="business_type_id"
            id="business_type_list">
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

<div class="form-group {{ $errors->has('gender_id') ? 'has-error' : '' }}">
	<label for="gender_id" class="col-sm-2 control-label">Sexo:</label>
	<div class="col-sm-8">
		<div class="input-group">
			<span class="input-group-addon"><i class="fa fa-question-circle"></i></span>
			{!! Form::select('$business_type_id', $business_types, $value = null, ['id'=>'genders_list', 'class'=>'form-control select2']) !!}
		</div>
	</div>
</div>

