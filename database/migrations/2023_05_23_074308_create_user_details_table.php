<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->string('address', 255);
            $table->string('phone', 15);

            $table->timestamps();


            // sintassi per creare una foreign key nella nuova tabella
            // devo aggiungere una serie di indicazioni che specifichi:
            $table->foreign('user_id')
                ->references('id') // il campo a cui si riferisce
                ->on('users') // la tabella di questo campo a cui si collega
                ->onDelete('cascade'); // cosa fare quando il nostro dato viene cancellato
                // 'cascade' elimina la riga di questa tabella quando la riga a cui fa riferimento la FK viene eliminata
                // 'set null' setta a valore NULL la FK quando la riga a cui è collegata nell'altra tabella viene eliminata
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_details');
    }
};
