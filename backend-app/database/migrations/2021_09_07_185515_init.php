<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enum\Order\DeliveryModeEnum;
use App\Enum\Order\OrderStatusEnum;
use App\Models\Order\Order;
use App\Models\Order\OrderBillingAddress;
use App\Models\Order\OrderItem;
use App\Models\Order\OrderShippingAddress;
use App\Models\Product\Product;
use App\Models\Product\ProductPrice;
use App\Models\User;

class Init extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Product::TABLE_NAME, function (Blueprint $table) {
            $table->timestamps();
            $table->softDeletes();
            $table->increments('id');
            $table->string('name', 128);
        });

        Schema::create(ProductPrice::TABLE_NAME, function (Blueprint $table) {
            $table->timestamps();
            $table->softDeletes();
            $table->increments('id');
            $table->unsignedInteger(Product::FOREIGN_KEY_NAME);
            $table->float('net_price');
            $table->float('gross_price');
            $table->float('tax')->default(27);
            $table->enum('currency', \App\Enum\CurrencyEnum::getEnumValues())->default(\App\Enum\CurrencyEnum::HUF);
        });

        Schema::create(OrderItem::TABLE_NAME, function (Blueprint $table) {
            $table->timestamps();
            $table->softDeletes();
            $table->increments('id');
            $table->unsignedInteger(Order::FOREIGN_KEY_NAME);
            $table->unsignedInteger(Product::FOREIGN_KEY_NAME);
            $table->float('quantity');
            $table->float('unit_net_price');
            $table->float('unit_gross_price');
            $table->float('tax');
            $table->enum('currency', \App\Enum\CurrencyEnum::getEnumValues())->default(\App\Enum\CurrencyEnum::HUF);
        });

        Schema::create(OrderBillingAddress::TABLE_NAME, function (Blueprint $table) {
            $table->timestamps();
            $table->softDeletes();
            $table->increments('id');
            $table->unsignedInteger(Order::FOREIGN_KEY_NAME);
            $table->string('city', 128);
            $table->string('postcode', 128);
            $table->string('address', 256);
        });

        Schema::create(OrderShippingAddress::TABLE_NAME, function (Blueprint $table) {
            $table->timestamps();
            $table->softDeletes();
            $table->increments('id');
            $table->unsignedInteger(Order::FOREIGN_KEY_NAME);
            $table->string('city', 128);
            $table->string('postcode', 128);
            $table->string('address', 256);
        });

        Schema::create(Order::TABLE_NAME, function (Blueprint $table) {
            $table->timestamps();
            $table->softDeletes();
            $table->increments('id');
            $table->unsignedBigInteger(User::FOREIGN_KEY_NAME)->nullable(true);
            $table->string('customer_name', 128);
            $table->string('customer_email', 128);
            $table->enum('delivery_mode', DeliveryModeEnum::getEnumValues());
            $table->enum('order_status', OrderStatusEnum::getEnumValues())->default(
                OrderStatusEnum::NEW
            );
        });

        Schema::table(ProductPrice::TABLE_NAME, function (Blueprint $table) {
            $table->foreign(Product::FOREIGN_KEY_NAME)
                ->references('id')
                ->on(Product::TABLE_NAME)
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table(OrderItem::TABLE_NAME, function (Blueprint $table) {
            $table->foreign(Order::FOREIGN_KEY_NAME)
                ->references('id')
                ->on(Order::TABLE_NAME)
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign(Product::FOREIGN_KEY_NAME)
                ->references('id')
                ->on(Product::TABLE_NAME)
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table(OrderBillingAddress::TABLE_NAME, function (Blueprint $table) {
            $table->foreign(Order::FOREIGN_KEY_NAME)
                ->references('id')
                ->on(Order::TABLE_NAME)
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table(OrderShippingAddress::TABLE_NAME, function (Blueprint $table) {
            $table->foreign(Order::FOREIGN_KEY_NAME)
                ->references('id')
                ->on(Order::TABLE_NAME)
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

        Schema::table(Order::TABLE_NAME, function (Blueprint $table) {
            $table->foreign(User::FOREIGN_KEY_NAME)
                ->references('id')
                ->on(User::TABLE_NAME)
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Order::TABLE_NAME);
        Schema::dropIfExists(OrderItem::TABLE_NAME);
        Schema::dropIfExists(OrderShippingAddress::TABLE_NAME);
        Schema::dropIfExists(OrderBillingAddress::TABLE_NAME);
        Schema::dropIfExists(ProductPrice::TABLE_NAME);
        Schema::dropIfExists(Product::TABLE_NAME);
    }
}
