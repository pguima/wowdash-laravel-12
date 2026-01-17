<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add new foreign keys
            // Making them nullable initially to facilitate migration if needed, or if user registration can be partial.
            $table->foreignId('department_id')->nullable()->after('email')->constrained('departments')->nullOnDelete();
            $table->foreignId('designation_id')->nullable()->after('department_id')->constrained('designations')->nullOnDelete();
        });

        // Migrate existing data before dropping old columns
        $this->migrateExistingData();

        Schema::table('users', function (Blueprint $table) {
            // We will drop the old columns.
            // WARNING: Data loss for these columns if not migrated.
            $table->dropColumn(['department', 'designation']);
        });
    }

    /**
     * Migrate existing string-based departments and designations to foreign keys
     */
    private function migrateExistingData(): void
    {
        // Get all users with old department/designation data
        $users = \DB::table('users')->whereNotNull('department')->orWhereNotNull('designation')->get();

        foreach ($users as $user) {
            $updates = [];

            // Migrate department
            if ($user->department) {
                $dept = \DB::table('departments')->where('name', $user->department)->first();
                if ($dept) {
                    $updates['department_id'] = $dept->id;
                } else {
                    // Create department if it doesn't exist
                    $deptId = \DB::table('departments')->insertGetId([
                        'name' => $user->department,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $updates['department_id'] = $deptId;
                }
            }

            // Migrate designation
            if ($user->designation) {
                $desig = \DB::table('designations')->where('name', $user->designation)->first();
                if ($desig) {
                    $updates['designation_id'] = $desig->id;
                } else {
                    // Create designation if it doesn't exist
                    $desigId = \DB::table('designations')->insertGetId([
                        'name' => $user->designation,
                        'department_id' => $updates['department_id'] ?? null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $updates['designation_id'] = $desigId;
                }
            }

            // Update user with new foreign keys
            if (!empty($updates)) {
                \DB::table('users')->where('id', $user->id)->update($updates);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('department')->nullable();
            $table->string('designation')->nullable();

            $table->dropForeign(['department_id']);
            $table->dropForeign(['designation_id']);
            $table->dropColumn(['department_id', 'designation_id']);
        });
    }
};
