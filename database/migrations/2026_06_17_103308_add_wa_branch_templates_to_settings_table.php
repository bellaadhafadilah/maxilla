<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->text('wa_template_tegal')->nullable();
            $table->text('wa_template_slawi')->nullable();
            $table->text('wa_template_brebes')->nullable();
            $table->dropColumn('wa_template');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->text('wa_template')->nullable();
            $table->dropColumn(['wa_template_tegal', 'wa_template_slawi', 'wa_template_brebes']);
        });
    }
};
