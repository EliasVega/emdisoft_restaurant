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
        Schema::create('sale_boxes', function (Blueprint $table) {
            $table->id();

            $table->decimal('cash_box',20,2);//inicio efectivo
            $table->decimal('in_cash',20,2);//ingresos de efectivo Recargas de caja
            $table->decimal('out_cash',20,2);//salidas de efectivo Salidas de caja
            $table->decimal('in_total',20,2);//total ingresos de todo tipo
            $table->decimal('out_total',20,2);//total de egresos de todo tipo
            $table->decimal('cash',20,2);//total entradas solo efectivo
            $table->decimal('departure',20,2);//total salidas solo efectivo

            $table->decimal('in_order_cash',20,2);//ingreso pedidos efectivo
            $table->decimal('in_order',20,2);//ingreso total de pedidos
            $table->decimal('order',20,2);//total de pedidos

            $table->decimal('in_invoice_cash',20,2);//ingreso ventas efectivo
            $table->decimal('in_invoice',20,2);//ing total de ventas
            $table->decimal('invoice',20,2);//total de ventas

            $table->decimal('in_advance_cash', 20,2);//ing avances en efectivo
            $table->decimal('in_advance', 20,2);//ing total de avances

            $table->decimal('in_ndinvoice_cash',20,2);//ingreso nota debito ventas efectivo
            $table->decimal('in_ndinvoice',20,2);//ingreso total nota debito ventas
            $table->decimal('ndinvoice',20,2);//total notas debito ventas

            $table->decimal('in_ncpurchase_cash',20,2); //ingreso total notas credito compras efectivo
            $table->decimal('in_ncpurchase',20,2); //ingreso total notas debito compras
            $table->decimal('ncpurchase',20,2);//total de notas credito compras

            $table->decimal('out_purchase_cash',20,2);//salida efectivo compras
            $table->decimal('out_purchase',20,2);//salida total compras
            $table->decimal('purchase',20,2);//total de compras

            $table->decimal('out_expense_cash',20,2);//salida efectivo compras gastos
            $table->decimal('out_expense',20,2);//salida total compras gastos
            $table->decimal('expense',20,2);//total de gastos

            $table->decimal('out_payment_cash',20,2);//total pagos anticipos salida
            $table->decimal('out_payment',20,2);//total pagos anticipos salida

            $table->decimal('out_ndpurchase_cash',20,2);//salida nota debito compras efectivo
            $table->decimal('out_ndpurchase',20,2);//salida nota debito compras efectivo
            $table->decimal('ndpurchase',20,2);//total de notas debito compras

            $table->decimal('out_ncinvoice_cash',20,2); //salida efectivo notas credito ventas
            $table->decimal('out_ncinvoice',20,2); //salida total notas credito ventas
            $table->decimal('ncinvoice',20,2);//total de notas credito ventas

            $table->string('verification_code_open',12);//codigo verif apertura de caja
            $table->string('verification_code_close',12)->nullable();//cod verif cierre de caja
            $table->enum('status', ['open', 'close'])->default('open');

            $table->foreignId('branch_id')->constrained();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade');
            $table->foreignId('user_open_id')
            ->references('id')
            ->on('users');
            $table->foreignId('user_close_id')
            ->nullable()
            ->references('id')
            ->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_boxes');
    }
};
