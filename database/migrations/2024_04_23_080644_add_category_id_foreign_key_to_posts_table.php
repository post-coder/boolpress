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
        Schema::table('posts', function (Blueprint $table) {
            
            // questo ->constrained() obbliga il database (e laravel) a verificare che ogni elmento inserito in quella colonna
            // abbia l'id corrispettivo nella tabella collegata
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // qui dobbiamo scrivere il codice che ci annulla l'aggiunta della chiave esterna
            // nella stringa del parametro di dropForeign() dobbiamo scrivere così:
            // "tabella_campo_foreign"
            // questo ci rimuoverà SOLO il vincolo
            $table->dropForeign('posts_category_id_foreign');

            // poi dobbiamo cancellare la colonna
            $table->dropColumn('category_id');
        });
    }
};
