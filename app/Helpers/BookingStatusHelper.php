<?php

if (!function_exists('booking_status_badge')) {
    function booking_status_badge(string $status): array
    {
        return match ($status) {
            'confirmed' => [
                'label' => __('messages.booking_confirmed'),
                'class' => 'success',
            ],
            'completed' => [
                'label' => __('messages.booking_completed'),
                'class' => 'primary',
            ],
            'no_show' => [
                'label' => __('messages.booking_no_show'),
                'class' => 'warning',
            ],
            'cancelled' => [
                'label' => __('messages.booking_cancelled'),
                'class' => 'danger',
            ],
             default => [
                // ⬅⬅⬅ هنا التعديل المهم
                'label' => __('messages.status_blocked'),
                'class' => 'dark',
            ], 
        };
    }
}
