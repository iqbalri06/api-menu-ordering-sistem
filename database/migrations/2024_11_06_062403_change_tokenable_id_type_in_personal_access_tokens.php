<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ChangeTokenableIdTypeInPersonalAccessTokens extends Migration
{
    public function up()
    {
        // First, add a new UUID column
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            $table->uuid('tokenable_id_new')->nullable();
        });

        // Convert the existing IDs to UUID format
        DB::statement('UPDATE personal_access_tokens SET tokenable_id_new = encode(decode(md5(tokenable_id::text), \'hex\'), \'hex\')::uuid');

        // Drop the old column
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            $table->dropColumn('tokenable_id');
        });

        // Rename the new column to the original name
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            $table->renameColumn('tokenable_id_new', 'tokenable_id');
        });
    }

    public function down()
    {
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            $table->bigInteger('tokenable_id_new')->nullable();
        });

        // Convert back to bigInteger (note: this might not preserve the original IDs)
        DB::statement('UPDATE personal_access_tokens SET tokenable_id_new = tokenable_id::text::bigint');

        Schema::table('personal_access_tokens', function (Blueprint $table) {
            $table->dropColumn('tokenable_id');
        });

        Schema::table('personal_access_tokens', function (Blueprint $table) {
            $table->renameColumn('tokenable_id_new', 'tokenable_id');
            $table->bigInteger('tokenable_id')->change();
        });
    }
}