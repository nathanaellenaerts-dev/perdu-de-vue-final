<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Créer la nouvelle table `photos`
        Schema::create('photos', function (Blueprint $table) {$table->id();
            $table->foreignId('item_id')->constrained()->cascadeOnDelete();$table->string('path');
            $table->boolean('is_cover')->default(false);$table->timestamps();
        });

        // 2. Migration des anciennes photos uniques vers la nouvelle table (si la colonne existe)
        if (Schema::hasColumn('items', 'photo')) {
            $items = DB::table('items')->whereNotNull('photo')->get();
            foreach ($items as$item) {
                DB::table('photos')->insert([
                    'item_id' => $item->id,
                    'path' => $item->photo,
                    'is_cover' => true, // L'ancienne photo devient la couverture par défaut
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 3. Supprimer l'ancienne colonne `photo` de la table `items`
            Schema::table('items', function (Blueprint $table) {$table->dropColumn('photo');
            });
        }
    }

    public function down(): void
    {
        // Restauration en cas de rollback (remet la colonne photo sur items)
        Schema::table('items', function (Blueprint $table) {$table->string('photo')->nullable();
        });

        // Remet la première photo de couverture dans la colonne unique
        $covers = DB::table('photos')->where('is_cover', true)->get();
        foreach ($covers as$cover) {
            DB::table('items')->where('id', $cover->item_id)->update(['photo' =>$cover->path]);
        }

        Schema::dropIfExists('photos');
    }
};
