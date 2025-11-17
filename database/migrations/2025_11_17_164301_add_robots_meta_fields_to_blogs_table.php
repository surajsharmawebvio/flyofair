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
        Schema::table('blogs', function (Blueprint $table) {
            $table->boolean('robots_index')->default(true)->after('faqs')->comment('SEO: Allow search engines to index this page (true=index, false=noindex)');
            $table->boolean('robots_follow')->default(true)->after('robots_index')->comment('SEO: Allow search engines to follow links on this page (true=follow, false=nofollow)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->dropColumn(['robots_index', 'robots_follow']);
        });
    }
};
