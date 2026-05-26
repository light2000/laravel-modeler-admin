<?php

return [
    'key' => 'shop',
    'label' => __('shop::permissions.shop'),
    'children' => [
        [
            'key' => 'shop.category',
            'label' => __('shop::permissions.shop.category'),
            'actions' => [
                ['key' => 'shop.category.store', 'label' => __('shop::permissions.shop.category.store')],
                ['key' => 'shop.category.update', 'label' => __('shop::permissions.shop.category.update')],
                ['key' => 'shop.category.index', 'label' => __('shop::permissions.shop.category.index')],
                ['key' => 'shop.category.show', 'label' => __('shop::permissions.shop.category.show')],
                ['key' => 'shop.category.destroy', 'label' => __('shop::permissions.shop.category.destroy')],
            ],
        ],
        [
            'key' => 'shop.product',
            'label' => __('shop::permissions.shop.product'),
            'actions' => [
                ['key' => 'shop.product.store', 'label' => __('shop::permissions.shop.product.store')],
                ['key' => 'shop.product.update', 'label' => __('shop::permissions.shop.product.update')],
                ['key' => 'shop.product.index', 'label' => __('shop::permissions.shop.product.index')],
                ['key' => 'shop.product.show', 'label' => __('shop::permissions.shop.product.show')],
                ['key' => 'shop.product.destroy', 'label' => __('shop::permissions.shop.product.destroy')],
            ],
        ],
        [
            'key' => 'shop.actor',
            'label' => __('shop::permissions.shop.actor'),
            'actions' => [
                ['key' => 'shop.actor.store', 'label' => __('shop::permissions.shop.actor.store')],
                ['key' => 'shop.actor.update', 'label' => __('shop::permissions.shop.actor.update')],
                ['key' => 'shop.actor.index', 'label' => __('shop::permissions.shop.actor.index')],
                ['key' => 'shop.actor.show', 'label' => __('shop::permissions.shop.actor.show')],
                ['key' => 'shop.actor.destroy', 'label' => __('shop::permissions.shop.actor.destroy')],
            ],
        ],
        [
            'key' => 'shop.athlete',
            'label' => __('shop::permissions.shop.athlete'),
            'actions' => [
                ['key' => 'shop.athlete.store', 'label' => __('shop::permissions.shop.athlete.store')],
                ['key' => 'shop.athlete.update', 'label' => __('shop::permissions.shop.athlete.update')],
                ['key' => 'shop.athlete.index', 'label' => __('shop::permissions.shop.athlete.index')],
                ['key' => 'shop.athlete.show', 'label' => __('shop::permissions.shop.athlete.show')],
                ['key' => 'shop.athlete.destroy', 'label' => __('shop::permissions.shop.athlete.destroy')],
            ],
        ],
    ],
];
