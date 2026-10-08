<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\McpAuditLog;
use App\Models\McpToken;
use App\Models\Plan;
use App\Models\PlatformModule;
use Database\Seeders\PlatformSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlatformTest extends TestCase
{
    use RefreshDatabase;

    public function test_syncs_modules_from_blocks_config(): void
    {
        $this->artisan('platform:sync-modules')->assertSuccessful();

        $this->assertGreaterThan(40, PlatformModule::count());
        $this->assertSame(7, PlatformModule::where('block_key', 'core')->count());
    }

    public function test_modules_scoped_per_plan_and_company(): void
    {
        $this->seed(PlatformSeeder::class);

        $company = Company::create([
            'name' => 'Test GmbH',
            'slug' => 'test-gmbh',
            'plan_id' => Plan::where('slug', 'basic')->value('id'),
        ]);

        $this->assertTrue($company->hasModule('core-dashboard'));
        $this->assertFalse($company->hasModule('creator-documents'));

        $company->moduleOverrides()->attach(
            PlatformModule::where('key', 'core-dashboard')->value('id'),
            ['enabled' => false]
        );

        $this->assertFalse($company->fresh()->hasModule('core-dashboard'));
    }

    public function test_mcp_tokens_authenticate_by_scope(): void
    {
        [, $plain] = McpToken::issue('test', 'read');

        $this->withHeader('Authorization', 'Bearer '.$plain)
            ->getJson('/api/mcp/health')
            ->assertOk()
            ->assertJsonPath('ok', true);

        $this->withHeader('Authorization', 'Bearer '.$plain)
            ->postJson('/api/mcp/artisan', ['command' => 'migrate:status'])
            ->assertForbidden();
    }

    public function test_mcp_actions_are_audit_logged(): void
    {
        [, $plain] = McpToken::issue('audit', 'full');

        $this->withHeader('Authorization', 'Bearer '.$plain)
            ->getJson('/api/mcp/modules')
            ->assertOk();

        $this->assertTrue(McpAuditLog::where('action', 'GET api/mcp/modules')->exists());
    }
}
