<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
	public function up(): void
	{
		// Foreign keylarning haqiqiy nomlarini olish
		$foreignKeys = $this->getForeignKeys('model_has_roles');

		// Foreign keylarni olib tashlash
		Schema::table('model_has_roles', function (Blueprint $table) use ($foreignKeys) {
			foreach ($foreignKeys as $foreignKey) {
				$table->dropForeign($foreignKey);
			}
		});

		// Model type'ni yangilash
		DB::table('model_has_roles')
			->where('model_type', 'AppModelsAccount')
			->update(['model_type' => 'App\Models\Account']);

		// PRIMARY KEYni o'zgartirish
		Schema::table('model_has_roles', function (Blueprint $table) {
			$table->dropPrimary();
			$table->primary(['role_id', 'model_id', 'model_type']);
		});

		// model_type ustunining default qiymatini o'zgartirish
		DB::statement('ALTER TABLE model_has_roles MODIFY model_type VARCHAR(255) DEFAULT "App\\\\Models\\\\Account"');

		// Foreign keylarni qayta qo'shish
		Schema::table('model_has_roles', function (Blueprint $table) {
			$table->foreign('role_id')
				->references('id')
				->on('roles')
				->onDelete('cascade');
			$table->foreign('model_id')
				->references('id')  // Account modelida 'id' primary key
				->on('accounts')    // accounts jadvali, users emas
				->onDelete('cascade');
		});
	}

	public function down(): void
	{
		// Foreign keylarni olib tashlash
		$foreignKeys = $this->getForeignKeys('model_has_roles');

		Schema::table('model_has_roles', function (Blueprint $table) use ($foreignKeys) {
			foreach ($foreignKeys as $foreignKey) {
				$table->dropForeign($foreignKey);
			}
		});

		// PRIMARY KEYni eski holatga qaytarish
		Schema::table('model_has_roles', function (Blueprint $table) {
			$table->dropPrimary();
			$table->primary(['role_id', 'model_id', 'model_type']);
		});

		// model_type ustunini NULL qilish
		DB::statement('ALTER TABLE model_has_roles MODIFY model_type VARCHAR(255) DEFAULT NULL');

		// Ma'lumotlarni rollback qilish
		DB::table('model_has_roles')
			->where('model_type', 'App\Models\Account')
			->update(['model_type' => 'AppModelsAccount']);

		// Foreign keylarni qayta tiklash
		Schema::table('model_has_roles', function (Blueprint $table) {
			$table->foreign('role_id')
				->references('id')
				->on('roles')
				->onDelete('cascade');
			$table->foreign('model_id')
				->references('id')
				->on('accounts')  // accounts jadvali
				->onDelete('cascade');
		});
	}

	// Foreign keylarni olish uchun yordamchi metod
	private function getForeignKeys($table): array
	{
		$conn = Schema::getConnection();
		$foreignKeys = [];

		$results = $conn->select(
			"SELECT CONSTRAINT_NAME
             FROM information_schema.TABLE_CONSTRAINTS
             WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND CONSTRAINT_TYPE = 'FOREIGN KEY'",
			[$conn->getDatabaseName(), $table]
		);

		foreach ($results as $result) {
			$foreignKeys[] = $result->CONSTRAINT_NAME;
		}

		return $foreignKeys;
	}
};
