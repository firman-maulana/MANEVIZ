<?php

namespace Database\Seeders;

use App\Models\HowToOrderStep;
use Illuminate\Database\Seeder;

class HowToOrderStepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $steps = [
            [
                'order' => 1,
                'content_id' => 'Pilih barang yang ingin Anda beli di halaman <span class="highlight">SHOP</span>, kemudian klik item yang ingin dibeli ke halaman <span class="highlight">PRODUCT</span>.',
                'content_en' => 'Choose the item that you would like to purchase at the <span class="highlight">SHOP</span> page, and then click the item to proceed to the <span class="highlight">PRODUCT</span> page.',
                'is_active' => true,
            ],
            [
                'order' => 2,
                'content_id' => 'Isi jumlah produk pada kolom <span class="highlight">QUANTITY</span>, lalu klik <span class="highlight">ADD TO CART</span>. Ketika <span class="highlight">CART</span> sudah terisi, Anda dapat memperbarui keranjang (menghapus item yang tidak diinginkan) atau mengubah jumlah kuantitas di halaman <span class="highlight">SHOPPING CART</span>.',
                'content_en' => 'Fill in the number of products on the <span class="highlight">QUANTITY</span> column, and then click <span class="highlight">ADD TO CART</span>. When the <span class="highlight">CART</span> is filled, you can update the cart (deleting unwanted items) or change the number of quantity on the <span class="highlight">SHOPPING CART</span> page.',
                'is_active' => true,
            ],
            [
                'order' => 3,
                'content_id' => 'Isi informasi formulir pada halaman <span class="highlight">ORDER DETAIL</span>. Jika Anda ingin memberikan instruksi khusus pada pesanan Anda, silakan tulis di kolom <span class="highlight">NOTE</span> yang disediakan di bagian bawah halaman <span class="highlight">ORDER DETAIL</span>.',
                'content_en' => 'Fill the information form on the <span class="highlight">ORDER DETAIL</span> page. If you want to make a certain instruction on your order, please note on the <span class="highlight">NOTE</span> column provided on the bottom of the <span class="highlight">ORDER DETAIL</span> page.',
                'is_active' => true,
            ],
            [
                'order' => 4,
                'content_id' => 'Setelah selesai, Anda akan mendapatkan <span class="highlight">E-MAIL</span> berisi <span class="highlight">INVOICE</span> dan <span class="highlight">PAYMENT CONFIRMATION CODE</span>.',
                'content_en' => 'Once completed, you will get an <span class="highlight">E-MAIL</span> with <span class="highlight">INVOICE</span> and <span class="highlight">PAYMENT CONFIRMATION CODE</span>.',
                'is_active' => true,
            ],
            [
                'order' => 5,
                'content_id' => 'Silakan lanjutkan ke pembayaran melalui bank yang disediakan (<span class="highlight">BCA</span>). Sertakan <span class="highlight">PAYMENT CONFIRMATION CODE</span> saat melakukan pembayaran baik melalui <span class="highlight">ATM</span> atau <span class="highlight">INTERNET BANKING</span>.',
                'content_en' => 'Please proceed to payment via the provided bank (<span class="highlight">BCA</span>). Include the <span class="highlight">PAYMENT CONFIRMATION CODE</span> when making the payment either through <span class="highlight">ATM</span> or <span class="highlight">INTERNET BANKING</span>.',
                'is_active' => true,
            ],
            [
                'order' => 6,
                'content_id' => 'Setelah pembayaran selesai, silakan konfirmasi dengan menyertakan <span class="highlight">PAYMENT CONFIRMATION CODE</span>. Kami akan memvalidasi status pembayaran dan mengirimkan barang yang dipesan.',
                'content_en' => 'After the payment is done, please confirm it by including the <span class="highlight">PAYMENT CONFIRMATION CODE</span>. We will validate the payment status and ship the ordered items.',
                'is_active' => true,
            ],
        ];

        foreach ($steps as $step) {
            HowToOrderStep::create($step);
        }
    }
}
