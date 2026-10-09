<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // COMPLYN Core
        Schema::create('core_obligations', function (Blueprint $t) {
            $t->id();
            $t->foreignId('company_id')->constrained()->cascadeOnDelete();
            $t->string('title');
            $t->text('description')->nullable();
            $t->unsignedSmallInteger('interval_months')->default(12);
            $t->date('next_due_at')->nullable();
            $t->string('status')->default('active'); // active|paused|done
            $t->timestamps();
        });
        Schema::create('core_deadlines', function (Blueprint $t) {
            $t->id();
            $t->foreignId('company_id')->constrained()->cascadeOnDelete();
            $t->foreignId('core_obligation_id')->nullable()->constrained('core_obligations')->nullOnDelete();
            $t->foreignId('responsible_id')->nullable()->constrained('users')->nullOnDelete();
            $t->string('title');
            $t->date('due_at');
            $t->string('status')->default('open'); // open|done
            $t->timestamps();
        });
        Schema::create('core_tasks', function (Blueprint $t) {
            $t->id();
            $t->foreignId('company_id')->constrained()->cascadeOnDelete();
            $t->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $t->string('title');
            $t->date('due_at')->nullable();
            $t->string('status')->default('open'); // open|done
            $t->timestamps();
        });
        Schema::create('core_responsibilities', function (Blueprint $t) {
            $t->id();
            $t->foreignId('company_id')->constrained()->cascadeOnDelete();
            $t->foreignId('core_obligation_id')->constrained('core_obligations')->cascadeOnDelete();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('role')->default('Verantwortlich');
            $t->timestamps();
        });
        Schema::create('core_evidences', function (Blueprint $t) {
            $t->id();
            $t->foreignId('company_id')->constrained()->cascadeOnDelete();
            $t->foreignId('core_obligation_id')->constrained('core_obligations')->cascadeOnDelete();
            $t->foreignId('file_id')->nullable()->constrained('files')->nullOnDelete();
            $t->string('title');
            $t->text('note')->nullable();
            $t->timestamps();
        });

        // Community: votes, accepted answers, expert labels
        Schema::create('community_votes', function (Blueprint $t) {
            $t->id();
            $t->foreignId('community_comment_id')->constrained('community_comments')->cascadeOnDelete();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->timestamps();
            $t->unique(['community_comment_id', 'user_id']);
        });
        Schema::table('community_posts', function (Blueprint $t) {
            $t->foreignId('accepted_comment_id')->nullable()->constrained('community_comments')->nullOnDelete();
            $t->string('status')->default('open')->after('body');
        });
        Schema::table('users', function (Blueprint $t) {
            $t->boolean('is_expert')->default(false);
            $t->string('expert_label')->nullable();
        });

        // Connect: expert profiles + matching criteria
        Schema::create('connect_experts', function (Blueprint $t) {
            $t->id();
            $t->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $t->string('name');
            $t->string('specialty');
            $t->foreignId('industry_id')->nullable()->constrained('industries')->nullOnDelete();
            $t->string('location')->nullable();
            $t->unsignedTinyInteger('experience_years')->default(0);
            $t->decimal('hourly_rate', 8, 2)->nullable();
            $t->string('availability')->default('available'); // available|busy|unavailable
            $t->decimal('rating', 3, 1)->nullable();
            $t->text('bio')->nullable();
            $t->timestamps();
        });
        Schema::table('connect_requests', function (Blueprint $t) {
            $t->foreignId('connect_expert_id')->nullable()->constrained('connect_experts')->nullOnDelete();
        });

        // Docs: expiry + release
        Schema::table('documents', function (Blueprint $t) {
            $t->date('expires_at')->nullable();
            $t->timestamp('released_at')->nullable();
        });

        // Library: download counters
        Schema::table('library_articles', function (Blueprint $t) {
            $t->unsignedInteger('downloads')->default(0);
        });
        Schema::table('library_templates', function (Blueprint $t) {
            $t->unsignedInteger('downloads')->default(0);
        });

        // Academy: quizzes, attempts, participation
        Schema::create('academy_quizzes', function (Blueprint $t) {
            $t->id();
            $t->foreignId('academy_lesson_id')->constrained('academy_lessons')->cascadeOnDelete();
            $t->string('question');
            $t->json('options');
            $t->unsignedTinyInteger('correct')->default(0);
            $t->timestamps();
        });
        Schema::create('academy_attempts', function (Blueprint $t) {
            $t->id();
            $t->foreignId('academy_lesson_id')->constrained('academy_lessons')->cascadeOnDelete();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->unsignedTinyInteger('score')->default(0);
            $t->boolean('passed')->default(false);
            $t->timestamps();
        });

        // Exchange: thematic groups + discussions
        Schema::create('exchange_groups', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('topic')->nullable();
            $t->timestamps();
        });
        Schema::create('exchange_topics', function (Blueprint $t) {
            $t->id();
            $t->foreignId('exchange_group_id')->constrained('exchange_groups')->cascadeOnDelete();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('title');
            $t->text('body');
            $t->timestamps();
        });
        Schema::create('exchange_topic_comments', function (Blueprint $t) {
            $t->id();
            $t->foreignId('exchange_topic_id')->constrained('exchange_topics')->cascadeOnDelete();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->text('body');
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exchange_topic_comments');
        Schema::dropIfExists('exchange_topics');
        Schema::dropIfExists('exchange_groups');
        Schema::dropIfExists('academy_attempts');
        Schema::dropIfExists('academy_quizzes');
        Schema::table('library_templates', fn (Blueprint $t) => $t->dropColumn('downloads'));
        Schema::table('library_articles', fn (Blueprint $t) => $t->dropColumn('downloads'));
        Schema::table('documents', fn (Blueprint $t) => $t->dropColumn(['expires_at', 'released_at']));
        Schema::table('connect_requests', fn (Blueprint $t) => $t->dropConstrainedForeignId('connect_expert_id'));
        Schema::dropIfExists('connect_experts');
        Schema::table('users', fn (Blueprint $t) => $t->dropColumn(['is_expert', 'expert_label']));
        Schema::table('community_posts', fn (Blueprint $t) => $t->dropConstrainedForeignId('accepted_comment_id'));
        Schema::table('community_posts', fn (Blueprint $t) => $t->dropColumn('status'));
        Schema::dropIfExists('community_votes');
        collect(['core_evidences', 'core_responsibilities', 'core_tasks', 'core_deadlines', 'core_obligations'])
            ->each(fn ($t) => Schema::dropIfExists($t));
    }
};
