@extends('admin')
@section('content')

        <div class="container">
            <div class="content">
                <div class="title_apka">Edition du compte</div><BR><BR>

                {!! Form::open(array('url' => '/admin/user/update/'.$user->id)) !!}
                <input type="hidden" name="user_id" value="{{ $user->id}}"/>
                <div class="form-group">
                        {!! Form::label('Nom') !!}
                        {!! Form::text('name', $user->name, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Nom')) !!}
                </div>
                <div class="form-group">
                        {!! Form::label('Email') !!}
                        {!! Form::text('email', $user->email, 
                            array('required', 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Email')) !!}
                </div>
                <div class="form-group">
                        {!! Form::label('Mot de passe') !!}
                        {!! Form::text('password', null, 
                            array(null, 
                                  'class'=>'form-control', 
                                  'placeholder'=>'Mot de passe')) !!}
                </div>
                <div class="form-group">
                        {!! Form::label('Actif') !!}
                        {!! Form::checkbox('actif', 1, $user->actif) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('Rôles de l\'utilisateur') !!}<BR>
                    <select multiple="multiple" name="roles[]" id="roles">
                        @foreach($roles as $role)
                                <option value="{!! $role->id !!}" @if(in_array($role->name,$userroles)) selected @endif >{!! $role->name !!}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                        {!! Form::submit('Enregistrer', 
                          array('class'=>'btn btn-primary')) !!} @if($suppUser==0)<a href="/admin/user/destroy/{{ $user->id }}" class="btn btn-danger pull-left" style="margin-right: 3px;" onclick="if(!confirm('Etes-vous sûr de vouloire supprimer cet utilisateur ?')){return false;};">Supprimer</a>@endif<a href="/admin/client/edit/{{ $user->id_client }}">Retour</A>
                    </div>
                {!! Form::close() !!}       
            </div>
        </div>
@endsection