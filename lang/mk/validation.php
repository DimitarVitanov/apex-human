<?php

/*
|--------------------------------------------------------------------------
| Macedonian validation messages for the public site forms.
|--------------------------------------------------------------------------
| Covers every rule used by the apply / contact / booking endpoints plus the
| common core rules, so visitors browsing in Macedonian never see English
| validation errors. Field names are humanised via the `attributes` map.
*/

return [
    'accepted' => 'Полето :attribute мора да биде прифатено.',
    'after' => 'Полето :attribute мора да биде датум по :date.',
    'alpha' => 'Полето :attribute може да содржи само букви.',
    'alpha_dash' => 'Полето :attribute може да содржи само букви, бројки, цртички и долни црти.',
    'alpha_num' => 'Полето :attribute може да содржи само букви и бројки.',
    'array' => 'Полето :attribute мора да биде листа.',
    'before' => 'Полето :attribute мора да биде датум пред :date.',
    'between' => [
        'array' => 'Полето :attribute мора да има помеѓу :min и :max ставки.',
        'file' => 'Полето :attribute мора да биде помеѓу :min и :max килобајти.',
        'numeric' => 'Полето :attribute мора да биде помеѓу :min и :max.',
        'string' => 'Полето :attribute мора да има помеѓу :min и :max знаци.',
    ],
    'boolean' => 'Полето :attribute мора да биде точно или неточно.',
    'confirmed' => 'Потврдата на полето :attribute не се совпаѓа.',
    'date' => 'Полето :attribute мора да биде валиден датум.',
    'declined' => 'Полето :attribute мора да биде одбиено.',
    'digits' => 'Полето :attribute мора да има :digits цифри.',
    'email' => 'Полето :attribute мора да биде валидна е-пошта.',
    'exists' => 'Избраната вредност за :attribute не е валидна.',
    'file' => 'Полето :attribute мора да биде датотека.',
    'filled' => 'Полето :attribute мора да има вредност.',
    'gt' => [
        'numeric' => 'Полето :attribute мора да биде поголемо од :value.',
        'string' => 'Полето :attribute мора да има повеќе од :value знаци.',
    ],
    'image' => 'Полето :attribute мора да биде слика.',
    'in' => 'Избраната вредност за :attribute не е валидна.',
    'integer' => 'Полето :attribute мора да биде цел број.',
    'lt' => [
        'numeric' => 'Полето :attribute мора да биде помало од :value.',
        'string' => 'Полето :attribute мора да има помалку од :value знаци.',
    ],
    'max' => [
        'array' => 'Полето :attribute не смее да има повеќе од :max ставки.',
        'file' => 'Полето :attribute не смее да биде поголемо од :max килобајти.',
        'numeric' => 'Полето :attribute не смее да биде поголемо од :max.',
        'string' => 'Полето :attribute не смее да има повеќе од :max знаци.',
    ],
    'mimes' => 'Полето :attribute мора да биде датотека од тип: :values.',
    'min' => [
        'array' => 'Полето :attribute мора да има најмалку :min ставки.',
        'file' => 'Полето :attribute мора да биде најмалку :min килобајти.',
        'numeric' => 'Полето :attribute мора да биде најмалку :min.',
        'string' => 'Полето :attribute мора да има најмалку :min знаци.',
    ],
    'not_in' => 'Избраната вредност за :attribute не е валидна.',
    'numeric' => 'Полето :attribute мора да биде број.',
    'present' => 'Полето :attribute мора да биде присутно.',
    'regex' => 'Форматот на полето :attribute не е валиден.',
    'required' => 'Полето :attribute е задолжително.',
    'required_if' => 'Полето :attribute е задолжително кога :other е :value.',
    'required_with' => 'Полето :attribute е задолжително кога :values е присутно.',
    'same' => 'Полето :attribute мора да се совпаѓа со :other.',
    'size' => [
        'array' => 'Полето :attribute мора да содржи :size ставки.',
        'file' => 'Полето :attribute мора да биде :size килобајти.',
        'numeric' => 'Полето :attribute мора да биде :size.',
        'string' => 'Полето :attribute мора да има :size знаци.',
    ],
    'string' => 'Полето :attribute мора да биде текст.',
    'timezone' => 'Полето :attribute мора да биде валидна временска зона.',
    'unique' => 'Вредноста за :attribute е веќе зафатена.',
    'url' => 'Полето :attribute мора да биде валидна URL адреса.',

    'attributes' => [
        'full_name' => 'цело име',
        'name' => 'име',
        'email' => 'е-пошта',
        'age' => 'возраст',
        'country' => 'земја',
        'message' => 'порака',
        'current_state' => 'моментална состојба',
        'why_now' => 'зошто сега',
        'previous_experience' => 'претходно искуство',
        'twelve_month_goal' => 'цел за 12 месеци',
        'commitment' => 'посветеност',
        'investment' => 'инвестиција',
        'token' => 'токен',
        'slot_id' => 'термин',
    ],
];
