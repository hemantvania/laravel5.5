<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */
	
	'accepted'             => 'Den :attributet måste accepteras.',
	'url_validate'         => 'Den :attributet är inte en giltig URL.',
    'active_url'           => 'Den :attributet är inte en giltig URL.',
    'after'                => 'Den :attributet måste vara ett datum efter :date.',
    'after_or_equal'       => 'Den :attributet måste vara ett datum efter eller lika med :date.',
    'alpha'                => 'Den :attributet kan endast innehålla bokstäver.',
    'alpha_dash'           => 'Den :attributet kan endast innehålla bokstäver, siffror och bindestreck.',
    'alpha_num'            => 'Den :attributet kan endast innehålla bokstäver och siffror.',
    'array'                => 'Den :attributet måste vara en matris.',
    'before'               => 'Den :attributet måste vara ett datum före :date.',
    'before_or_equal'      => 'Den :attributet måste vara ett datum före eller lika med :date.',
    'between'              => [
        'numeric' => 'Den :attributet måste vara mellan :min och :max.',
        'file'    => 'Den :attributet måste vara mellan :min och :max kilobytes.',
        'string'  => 'Den :attributet måste vara mellan :min och :max characters.',
        'array'   => 'Den :attributet måste ha mellan :min och :max artiklar.',
    ],
    'boolean'              => 'Den :attributfältet måste vara sant eller falskt.',
    'confirmed'            => 'Den :attributet lösenordsbekräftelsen matchar inte.',
    'date'                 => 'Den :attributet är inte ett giltigt datum.',
    'date_format'          => 'Den :attributet matchar inte formatet :format.',
    'different'            => 'Den :attribut och: andra måste vara olika.',
    'digits'               => 'Den :attributet måste vara: digits siffror.',
    'digits_between'       => 'Den :attributet måste vara mellan:min and :max siffror.',
    'dimensions'           => 'Den :attributet har ogiltig bilddimensioner.',
    'distinct'             => 'Den :attributfältet har ett dubblettvärde.',
    'email'                => 'Den :attributet måste vara en giltig e-postadress.',
    'exists'               => 'Den valda: attributet är ogiltigt.',
    'file'                 => 'Den :attributet måste vara en fil.',
    'filled'               => 'Den :attributfältet måste ha ett värde.',
    'image'                => 'Den :attributet måste vara en bild.',
    'in'                   => 'Den valda: attributet är ogiltigt.',
    'in_array'             => 'Den :attributfältet existerar inte i: other.',
    'integer'              => 'Den :attributet måste vara ett heltal.',
    'ip'                   => 'Den :attributet måste vara en giltig IP-adress.',
    'ipv4'                 => 'Den :attributet måste vara en giltig IPv4-adress.',
    'ipv6'                 => 'Den :attributet måste vara en giltig IPv6-adress.',
    'json'                 => 'Den :attributet måste vara ett giltigt JSON-sträng.',
    'max'                  => [
        'numeric' => 'Den :attributet får inte vara större än :max.',
        'file'    => 'Den :attributet får inte vara större än :max kilobyte.',
        'string'  => 'Den :attributet får inte vara större än :max tecken.',
        'array'   => 'Den :attribut kan inte ha mer än :max artiklar.',
    ],
    'mimes'                => 'Den :attributet måste vara en fil av typen: :values.',
    'mimetypes'            => 'Den :attributet måste vara en fil av typen: :values.',
    'min'                  => [
        'numeric' => 'Den :attributet får inte vara större än :max.',
        'file'    => 'Den :attributet får inte vara större än :max kilobyte.',
        'string'  => 'Den :attributet får inte vara större än :max tecken.',
        'array'   => 'Den :attribut kan inte ha mer än :max artiklar.',
    ],
    'not_in'               => 'Den valda: attributet är ogiltigt.',
    'numeric'              => 'Den :attributet måste vara ett tal.',
    'present'              => 'Den :attributfältet måste vara närvarande.',
    'regex'                => 'Den :attribute-format är ogiltigt.',
    'required'             => 'Den :attributfält krävs.',
    'required_if'          => 'Den :attributfält krävs när :other is :value.',
    'required_unless'      => 'Den :attributfält krävs såvida inte :other  i :values.',
    'required_with'        => 'Den :attributfält krävs när :values är närvarande.',
    'required_with_all'    => 'Den :attributfält krävs när :values är närvarande.',
    'required_without'     => 'Den :attributfält krävs när :values inte är närvarande.',
    'required_without_all' => 'Den :attributfält krävs när none of :values är närvarande.',
    'same'                 => 'Den :attribute and :other måste matcha.',
    'size'                 => [
        'numeric' => 'Den :attributet måste vara :size.',
        'file'    => 'Den :attributet måste vara :size kilobyte.',
        'string'  => 'Den :attributet måste vara :size tecken.',
        'array'   => 'Den :attributet måste innehålla :size artiklar.',
    ],
    'string'               => 'Den :attributet måste vara en sträng.',
    'timezone'             => 'Den :attributet måste vara en giltig zon.',
    'unique'               => 'Den :attributet har redan tagits.',
    'uploaded'             => 'Den :Det gick inte att ladda upp attributet.',
    'url'                  => 'Den :attribute-format är ogiltigt.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
