<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Coach
        Schema::create('coach_sessions', function (Blueprint $t) {
            $t->id();
            $t->foreignId('company_id')->constrained()->cascadeOnDelete();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('topic')->nullable();
            $t->timestamps();
        });
        Schema::create('coach_messages', function (Blueprint $t) {
            $t->id();
            $t->foreignId('coach_session_id')->constrained('coach_sessions')->cascadeOnDelete();
            $t->string('role');
            $t->text('content');
            $t->timestamps();
        });
        Schema::create('coach_checklists', function (Blueprint $t) {
            $t->id();
            $t->foreignId('company_id')->constrained()->cascadeOnDelete();
            $t->string('title');
            $t->json('items')->nullable();
            $t->timestamps();
        });

        // Community
        Schema::create('community_posts', function (Blueprint $t) {
            $t->id();
            $t->foreignId('company_id')->constrained()->cascadeOnDelete();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('title');
            $t->text('body');
            $t->timestamps();
        });
        Schema::create('community_comments', function (Blueprint $t) {
            $t->id();
            $t->foreignId('community_post_id')->constrained('community_posts')->cascadeOnDelete();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->text('body');
            $t->timestamps();
        });
        Schema::create('community_groups', function (Blueprint $t) {
            $t->id();
            $t->foreignId('company_id')->constrained()->cascadeOnDelete();
            $t->string('name');
            $t->text('description')->nullable();
            $t->timestamps();
        });

        // Score
        Schema::create('score_metrics', function (Blueprint $t) {
            $t->id();
            $t->foreignId('company_id')->constrained()->cascadeOnDelete();
            $t->string('key');
            $t->string('name_de');
            $t->decimal('value', 10, 2)->default(0);
            $t->string('unit')->nullable();
            $t->timestamps();
            $t->unique(['company_id', 'key']);
        });
        Schema::create('score_reports', function (Blueprint $t) {
            $t->id();
            $t->foreignId('company_id')->constrained()->cascadeOnDelete();
            $t->string('title');
            $t->unsignedInteger('score')->default(0);
            $t->json('breakdown')->nullable();
            $t->timestamps();
        });

        // Connect
        Schema::create('connect_requests', function (Blueprint $t) {
            $t->id();
            $t->foreignId('company_id')->constrained()->cascadeOnDelete();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('title');
            $t->text('description')->nullable();
            $t->string('status')->default('open');
            $t->timestamps();
        });
        Schema::create('connect_messages', function (Blueprint $t) {
            $t->id();
            $t->foreignId('connect_request_id')->constrained('connect_requests')->cascadeOnDelete();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->text('body');
            $t->timestamps();
        });

        // Library
        Schema::create('library_articles', function (Blueprint $t) {
            $t->id();
            $t->foreignId('company_id')->nullable()->constrained()->cascadeOnDelete();
            $t->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $t->string('title');
            $t->text('body');
            $t->string('status')->default('published');
            $t->timestamps();
        });
        Schema::create('library_templates', function (Blueprint $t) {
            $t->id();
            $t->foreignId('company_id')->nullable()->constrained()->cascadeOnDelete();
            $t->string('name');
            $t->text('content');
            $t->string('type')->default('template');
            $t->timestamps();
        });

        // Creator
        Schema::create('creator_drafts', function (Blueprint $t) {
            $t->id();
            $t->foreignId('company_id')->constrained()->cascadeOnDelete();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('title');
            $t->text('content')->nullable();
            $t->string('type')->default('document');
            $t->string('status')->default('draft');
            $t->timestamps();
        });

        // Academy
        Schema::create('academy_courses', function (Blueprint $t) {
            $t->id();
            $t->string('title');
            $t->text('description')->nullable();
            $t->timestamps();
        });
        Schema::create('academy_lessons', function (Blueprint $t) {
            $t->id();
            $t->foreignId('academy_course_id')->constrained('academy_courses')->cascadeOnDelete();
            $t->string('title');
            $t->text('content')->nullable();
            $t->unsignedInteger('sort')->default(0);
            $t->timestamps();
        });
        Schema::create('academy_progress', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->foreignId('academy_lesson_id')->constrained('academy_lessons')->cascadeOnDelete();
            $t->timestamp('completed_at')->nullable();
            $t->timestamps();
            $t->unique(['user_id', 'academy_lesson_id']);
        });

        // Exchange
        Schema::create('exchange_listings', function (Blueprint $t) {
            $t->id();
            $t->foreignId('company_id')->constrained()->cascadeOnDelete();
            $t->string('title');
            $t->text('description')->nullable();
            $t->string('type')->default('offer');
            $t->string('status')->default('open');
            $t->timestamps();
        });
        Schema::create('exchange_inquiries', function (Blueprint $t) {
            $t->id();
            $t->foreignId('exchange_listing_id')->constrained('exchange_listings')->cascadeOnDelete();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->text('message');
            $t->timestamps();
        });
    }

    public function down(): void
    {
        collect(['exchange_inquiries','exchange_listings','academy_progress','academy_lessons','academy_courses','creator_drafts','library_templates','library_articles','connect_messages','connect_requests','score_reports','score_metrics','community_groups','community_comments','community_posts','coach_checklists','coach_messages','coach_sessions'])->each(fn ($t) => Schema::dropIfExists($t));
    }
};
