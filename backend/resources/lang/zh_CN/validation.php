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
    'accepted' => ':attribute必须接受。',
    'accepted_if' => '当:other等于:value时,:attribute必须接受。',
    'active_url' => ':attribute不是有效的URL。',
    'after' => ':attribute必须是:date之后的一个日期。',
    'after_or_equal' => ':attribute必须是:date之后或相同的日期。',
    'alpha' => ':attribute只能包含字母。',
    'alpha_dash' => ':attribute只能包含字母、数字、中划线或下划线。',
    'alpha_num' => ':attribute只能包含字母和数字。',
    'any_of' => ':attribute无效。',
    'array' => ':attribute必须是一个数组。',
    'ascii' => ':attribute只能包含单字节的字母、数字和符号。',
    'before' => ':attribute必须是:date之前的一个日期。',
    'before_or_equal' => ':attribute必须是:date之前或相同的日期。',
    'between' => [
        'array' => ':attribute必须包含:min至:max个元素。',
        'file' => ':attribute必须介于:min至:maxKB之间。',
        'numeric' => ':attribute必须介于:min至:max之间。',
        'string' => ':attribute必须介于:min至:max个字符之间。',
    ],
    'boolean' => ':attribute字段必须是true或false。',
    'can' => ':attribute 字段包含未被授权的值。',
    'confirmed' => ':attribute两次输入不匹配。',
    'current_password' => ':attribute不正确.',
    'date' => ':attribute不是一个合法日期。',
    'date_equals' => ':attribute必须是等于:date的日期。',
    'date_format' => ':attribute与格式:format不匹配。',
    'decimal' => ':attribute必须有:decimal位小数。',
    'declined' => '必须为"no", "off", 0, false.',
    'declined_if' => '当:other等于:value时.必须为"no", "off", 0, false.',
    'different' => ':attribute和:other必须不同。',
    'digits' => ':attribute必须是:digits位数字。',
    'digits_between' => ':attribute必须介于:min至:max位数字之间。',
    'dimensions' => ':attribute图片尺寸不正确。',
    'distinct' => ':attribute有重复值。',
    'doesnt_end_with' => ':attribute不能以:values结尾。',
    'doesnt_start_with' => ':attribute不能以:values开头。',
    'email' => ':attribute必须是合法的电子邮箱。',
    'ends_with' => ':attribute必须以:values结尾.',
    'enum' => ':attribute是无效的可选项',
    'exists' => '选定的:attribute无效。',
    'extensions' => ':attribute必须有以下扩展名::values.',
    'file' => ':attribute必须是文件',
    'filled' => ':attribute不能为空',
    'gt' => [
        'array' => ':attribute必须多于:value个项。',
        'file' => ':attribute必须大于:valueKB。',
        'numeric' => ':attribute必须大于:value。',
        'string' => ':attribute必须多于:value个字符。',
    ],
    'gte' => [
        'array' => ':attribute必须至少有:value个项。',
        'file' => ':attribute必须大于等于:valueKB。',
        'numeric' => ':attribute必须大于等于:value。',
        'string' => ':attribute必须至少:value个字符。',
    ],
    'hex_color' => ':attribute必须是有效的十六进制颜色代码.',
    'image' => ':attribute必须是 jpeg、png、bmp、gif、svg 格式的图像。',
    'in' => '选定的:attribute无效。',
    'in_array' => ':attribute不在:other中。',
    'in_array_keys' => ':attribute必须至少包含以下键名之一::values.',
    'integer' => ':attribute必须是整数。',
    'ip' => ':attribute必须是合法的IP地址。',
    'ipv4' => ':attribute必须是合法的IPv4地址。',
    'ipv6' => ':attribute必须是合法的IPv6地址。',
    'json' => ':attribute必须是合法的JSON字符串。',
    'list' => ':attribute必须是一个列表',
    'lowercase' => ':attribute必须是小写字符',
    'lt' => [
        'array' => ':attribute必须少于:value个项。',
        'file' => ':attribute必须小于:valueKB。',
        'numeric' => ':attribute必须小于:value。',
        'string' => ':attribute必须少于:value个字符。',
    ],
    'lte' => [
        'array' => ':attribute不能超过:value个项。',
        'file' => ':attribute必须小于等于:valueKB。',
        'numeric' => ':attribute必须小于等于:value。',
        'string' => ':attribute必须不超过:value个字符。',
    ],
    'mac_address' => ':attribute必须是有效的MAC地址.',
    'max' => [
        'array' => ':attribute不能超过:max项。',
        'file' => ':attribute不能大于:maxKB。',
        'numeric' => ':attribute不能大于:max。',
        'string' => ':attribute不能超过:max个字符。',
    ],
    'mimes' => ':attribute必须是以下类型文件：:values。',
    'mimetypes' => ':attribute必须是以下类型文件：:values。',
    'min' => [
        'array' => ':attribute至少有:min项。',
        'file' => ':attribute大小至少为:minKB。',
        'numeric' => ':attribute最小为:min。',
        'string' => ':attribute至少:min个字符。',
    ],
    'min_digits' => ':attribute必须是最小:min位的数字。',
    'missing' => ':attribute字段必须缺失。',
    'missing_if' => '当:other为:value时，:attribute字段必须缺失。',
    'missing_unless' => '除非:other为:value，否则:attribute字段必须缺失。',
    'missing_with' => '当:values 存在时，:attribute字段必须缺失。',
    'missing_with_all' => '当:values 都存在时，:attribute字段必须缺失。',
    'multiple_of' => ':attribute必须是:value的倍数.',
    'not_in' => '选定的:attribute无效。',
    'not_regex' => ':attribute格式无效。',
    'numeric' => ':attribute必须是数字。',
    'password' => [
        'letters' => ':attribute字段必须至少包含一个字母。',
        'mixed' => ':attribute字段必须同时包含大写和小写字母。',
        'numbers' => ':attribute字段必须至少包含一个数字。',
        'symbols' => ':attribute字段必须至少包含一个符号。',
        'uncompromised' => '给定的:attribute已出现在数据泄露中。请使用其他密码。',
    ],

    'present' => ':attribute字段必须存在。',
    'present_if' => '当:other为:value时，:attribute字段必须存在。',
    'present_unless' => '除非:other为:value，否则:attribute字段必须存在。',
    'present_with' => '当:values 存在时，:attribute字段必须存在。',
    'present_with_all' => '当:values 都存在时，:attribute字段必须存在。',

    'prohibited' => ':attribute字段是禁止的。',
    'prohibited_if' => '当:other为:value时，:attribute字段禁止填写。',
    'prohibited_if_accepted' => '当:other被接受时，:attribute字段禁止填写。',
    'prohibited_if_declined' => '当:other被拒绝时，:attribute字段禁止填写。',
    'prohibited_unless' => '除非:other是以下值之一:values，否则:attribute字段禁止填写。',
    'prohibits' => ':attribute字段禁止:other字段同时存在。',

    'regex' => ':attribute字段格式不正确。',

    'required' => ':attribute字段为必填项。',
    'required_array_keys' => ':attribute字段必须包含以下条目：:values。',
    'required_if' => '当:other为:value时，:attribute字段为必填项。',
    'required_if_accepted' => '当:other被接受时，:attribute字段为必填项。',
    'required_if_declined' => '当:other被拒绝时，:attribute字段为必填项。',
    'required_unless' => '除非:other是以下值之一:values，否则:attribute字段为必填项。',
    'required_with' => '当:values 存在时，:attribute字段为必填项。',
    'required_with_all' => '当:values 都存在时，:attribute字段为必填项。',
    'required_without' => '当:values 不存在时，:attribute字段为必填项。',
    'required_without_all' => '当:values 全部缺失时，:attribute字段为必填项。',

    'same' => ':attribute字段必须与:other相同。',

    'size' => [
        'array' => ':attribute字段必须包含:size 项。',
        'file' => ':attribute文件大小必须为:size KB。',
        'numeric' => ':attribute必须是:size。',
        'string' => ':attribute必须是:size 个字符。',
    ],

    'starts_with' => ':attribute字段必须以以下之一开头：:values。',
    'string' => ':attribute字段必须是字符串。',
    'timezone' => ':attribute字段必须是有效的时区。',
    'unique' => ':attribute已被占用。',
    'uploaded' => ':attribute上传失败。',
    'uppercase' => ':attribute字段必须为大写字母。',
    'url' => ':attribute字段必须是有效的URL。',
    'ulid' => ':attribute字段必须是有效的ULID。',
    'uuid' => ':attribute字段必须是有效的UUID。',

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
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
    ],
];
