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
	
	'accepted'             => 'Että :määrite on hyväksyttävä.',
	'url_validate'         => 'Että :määrite ei ole kelvollinen URL-osoite.',
    'active_url'           => 'Että :määrite ei ole kelvollinen URL-osoite.',
    'after'                => 'Että :määritteen on oltava päivä määrä sen jälkeen, kun :date.',
    'after_or_equal'       => 'Että :määritteen on oltava päivä määrä, jonka jälkeen tai yhtä suuri kuin :date.',
    'alpha'                => 'Että :määrite voi sisältää vain kirjaimia.',
    'alpha_dash'           => 'Että :määrite voi sisältää vain kirjaimia, numeroita ja viivoja.',
    'alpha_num'            => 'Että :määrite voi sisältää vain kirjaimia ja numeroita.',
    'array'                => 'Että :määritteen on oltava matriisi.',
    'before'               => 'Että :määritteen on oltava päivä määrä, ennen kuin :date.',
    'before_or_equal'      => 'Että :määritteen on oltava päivä määrä ennen tai yhtä suuri kuin :date.',
    'between'              => [
        'numeric' => 'Että :määritteen on oltava välillä :min ja :max.',
        'file'    => 'Että :määritteen on oltava välillä :min ja :max kilobytes.',
        'string'  => 'Että :määritteen on oltava välillä :min ja :max characters.',
        'array'   => 'Että :määritteen on oltava välillä :min ja :max kohteita.',
    ],
    'boolean'              => 'Että :määrite kentän on oltava tosi tai EPÄTOSI.',
    'confirmed'            => 'Että :määritteen vahvistus ei täsmää.',
    'date'                 => 'Että :määrite ei ole kelvollinen päivä määrä.',
    'date_format'          => 'Että :määrite ei vastaa muotoa :format.',
    'different'            => 'Että :attribuutin ja: muiden on oltava eri.',
    'digits'               => 'Että :määritteen on oltava:d digits numeroa.',
    'digits_between'       => 'Että :määritteen on oltava väliltä: :min ja :max numerot.',
    'dimensions'           => 'Että :määritteen kuva dimensiot ovat virheellisiä.',
    'distinct'             => 'Että :määrite kentän arvo on kaksinkertainen.',
    'email'                => 'Että :määritteen on oltava kelvollinen Sähkö posti osoite.',
    'exists'               => 'Valittu:-määrite on virheellinen.',
    'file'                 => 'Että :määritteen on oltava tiedosto.',
    'filled'               => 'Että :määrite kentällä on oltava arvo.',
    'image'                => 'Että :määritteen on oltava kuva.',
    'in'                   => 'Valittu:-määrite on virheellinen.',
    'in_array'             => 'Että :määrite kenttää ei ole kohteessa: other.',
    'integer'              => 'Että :määritteen on oltava kokonaisluku.',
    'ip'                   => 'Että :määritteen on oltava kelvollinen IP-osoite.',
    'ipv4'                 => 'Että :määritteen on oltava kelvollinen IPv4-osoite.',
    'ipv6'                 => 'Että :määritteen on oltava kelvollinen IPv6-osoite.',
    'json'                 => 'Että :määritteen on oltava kelvollinen JSON-merkki jono.',
    'max'                  => [
        'numeric' => 'Että :määrite ei saa olla suurempi kuin :max.',
        'file'    => 'Että :määrite ei saa olla suurempi kuin :max kilo.',
        'string'  => 'Että :määrite ei saa olla suurempi kuin :max merkkiä.',
        'array'   => 'Että :määritteellä ei saa olla enempää kuin :max kohteita.',
    ],
    'mimes'                => 'Että :määritteen on oltava tiedosto, jonka tyyppi on: :values.',
    'mimetypes'            => 'Että :määritteen on oltava tiedosto, jonka tyyppi on: :values.',
    'min'                  => [
        'numeric' => 'Että :määrite ei saa olla suurempi kuin :max.',
        'file'    => 'Että :määrite ei saa olla suurempi kuin :max kilo.',
        'string'  => 'Että :määrite ei saa olla suurempi kuin :max merkkiä.',
        'array'   => 'Että :määritteellä ei saa olla enempää kuin :max kohteita.',
    ],
    'not_in'               => 'Valittu:-määrite on virheellinen.',
    'numeric'              => 'Että :määritteen on oltava luku.',
    'present'              => 'Että :määrite kentän on oltava olemassa.',
    'regex'                => 'Että :määrite muoto ei kelpaa.',
    'required'             => 'Että :määrite kenttä on pakollinen.',
    'required_if'          => 'Että :määrite kenttä on pakollinen milloin :other is :value.',
    'required_unless'      => 'Että :määrite kenttä on pakollinen ellei :other sijaitsee :values.',
    'required_with'        => 'Että :määrite kenttä on pakollinen milloin :values on läsnä.',
    'required_with_all'    => 'Että :määrite kenttä on pakollinen milloin :values on läsnä.',
    'required_without'     => 'Että :määrite kenttä on pakollinen milloin :values ei ole läsnä.',
    'required_without_all' => 'Että :määrite kenttä on pakollinen milloin none of :values ovat läsnä.',
    'same'                 => 'Että :määrite and :other on vastattava.',
    'size'                 => [
        'numeric' => 'Että :määritteen on oltava :size.',
        'file'    => 'Että :määritteen on oltava :size kilo.',
        'string'  => 'Että :määritteen on oltava :size merkkiä.',
        'array'   => 'Että :määritteen on sisällettävä :size kohteita.',
    ],
    'string'               => 'Että :määritteen on oltava merkki jono.',
    'timezone'             => 'Että :määritteen on oltava kelvollinen vyöhyke.',
    'unique'               => 'Että :määrite on jo tehty.',
    'uploaded'             => 'Että :määritteen lataaminen epäonnistui.',
    'url'                  => 'Että :määrite muoto ei kelpaa.',

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
