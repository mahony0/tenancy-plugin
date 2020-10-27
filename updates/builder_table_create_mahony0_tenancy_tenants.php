<?php namespace Mahony0\Tenancy\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateMahony0TenancyTenants extends Migration
{
    public function up()
    {
        Schema::create('mahony0_tenancy_tenants', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('active')->nullable();
            $table->integer('usergroup_id')->nullable();

            $table->string('host')->nullable();
	        $table->string('theme')->nullable();
            $table->string('language')->nullable();

            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('mahony0_tenancy_tenants');
    }
}
