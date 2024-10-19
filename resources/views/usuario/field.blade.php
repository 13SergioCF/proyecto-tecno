<div class="container px-md-2 px-3">
    <div class="row">
        <div class="col-6 form-group">
            {!! Form::label('route_sheet_cite', 'Hoja de ruta:', ['class' => 'control-label']) !!}
            {!! Form::text('route_sheet_cite', null, [
                'class' => 'form-control',
                'placeholder' => 'Hoja de ruta',
                'required',
            ]) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-12 form-group">
            {!! Form::label('applicant_name', 'Funcionario solicitante:', ['class' => 'control-label']) !!}
            {!! Form::text('applicant_name', null, [
                'class' => 'form-control',
                'placeholder' => 'Funcionario (a) solicitante',
                'required',
            ]) !!}
        </div>
        <div class="col-md-6 col-12 form-group">
            {!! Form::label('applicant_position', 'Cargo del funcionario:', ['class' => 'control-label']) !!}
            {!! Form::text('applicant_position', null, [
                'class' => 'form-control',
                'placeholder' => 'Cargo del funcionario solicitante',
                'required',
            ]) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-12 form-group">
            {!! Form::label('request_justification', 'Justificación de la solicitud:', ['class' => 'form-label']) !!}
            {!! Form::textarea('request_justification', null, [
                'class' => 'form-control',
                'placeholder' => 'Justificación de la solicitud',
                'rows' => 2,
                'required',
            ]) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-12 form-group">
            {!! Form::label('results', 'Productos y/o resultados a lograr con los recursos solicitados:', [
                'class' => 'form-label',
            ]) !!}
            {!! Form::textarea('results', null, [
                'class' => 'form-control',
                'placeholder' => 'Productos y/o Resultados a lograr con los recursos solicitados',
                'rows' => 2,
                'required',
            ]) !!}
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12 text-right">
            <button type="submit" class="btn btn-{{ setting('theme_color') }}"><i class="fa fa-save"></i> Guardar
                Certificación</button>
            <a href="{!! route('users.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i> Cancelar</a>
        </div>
    </div>
</div>
