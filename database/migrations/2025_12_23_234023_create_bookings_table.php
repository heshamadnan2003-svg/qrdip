<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            // العلاقة مع الجهة
            $table->foreignId('organization_id')
                ->constrained()
                ->cascadeOnDelete();

            // العلاقة مع الخدمة
            $table->foreignId('service_id')
                ->constrained()
                ->cascadeOnDelete();

            // بيانات الحجز
            $table->date('booking_date');
            $table->time('start_time');
            $table->time('end_time');

            // بيانات العميل
            $table->string('customer_name');
            $table->string('customer_phone', 20);
            $table->string('customer_email');              // ✅ جديد (إجباري)
            $table->string('customer_address')->nullable(); // ✅ جديد (اختياري)

            // حالة الحجز
            $table->string('status')->default('confirmed');

            $table->timestamps();

            // منع حجز نفس الوقت مرتين لنفس الجهة
            $table->unique(
                ['organization_id', 'booking_date', 'start_time'],
                'unique_booking_slot'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
