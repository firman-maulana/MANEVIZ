<?php

namespace Database\Seeders;

use App\Models\RefundPolicy;
use Illuminate\Database\Seeder;

class RefundPolicySeeder extends Seeder
{
    public function run(): void
    {
        $policies = [
            [
                'section_key' => 'refund_policy',
                'title_id' => 'KEBIJAKAN PENGEMBALIAN DANA',
                'title_en' => 'REFUND POLICY',
                'content_id' => 'Barang harus dikembalikan dalam waktu 5 hari setelah barang diterima.

Barang harus memiliki kondisi asli seperti yang diserahkan saat penerimaan.

Kami berhak untuk menolak pengembalian dana atau penukaran apabila barang tersebut telah berubah bentuk, terjadi kerusakan, dicuci atau kedalamguannya akibat hal yang disebabkan.

Anda tidak dapat melakukan atau pengembalian dana untuk barang yang tidak memenuhi kriteria pengembalian. Jika anda menerima produk yang mengalami kerusakan atau cacat pada saat penerimaan pengiriman silahkan memberikan pemberitahuan terlebih dahulu dalam waktu 2 hari setelah anda menerima produk melalui email website@materialdesaster.com sebelum mengirim barang kembali.

Anda dapat mengggunakan jasa pengiriman lain untuk pengembalian barang. Untuk memastikan kami menerima barang yang anda kirim silahkan meminta nomor pelacakan dari pengirim dan konfirmasikan kepada kami lagi melalui email website@materialdesaster.com beserta nomor KONFIRMASI PEMBAYARAN anda.

Kemasa kembali barang pengembalian anda dengan aman.

Kirim barang pengembalian anda ke alamat: Material Desaster Jl. Wira Angun Angun No 4. Bandung.

Barang baru akan di kirim setelah kami menerima barang penukaran anda dan mengkonfirmasi pengembalian atau penukaran anda.

Kami tidak bertanggungjawab atas kehilangan barang pengembalian saat pengiriman kembali.

Biaya pengiriman awal tidak dapat dikembalikan.',
                'content_en' => 'Items must be returned within 5 days after receiving the goods.

Items must be in original condition as delivered upon receipt.

We reserve the right to refuse refunds or exchanges if the item has changed shape, been damaged, washed or compromised due to circumstances caused by the customer.

You cannot make a refund for items that do not meet the return criteria. If you receive a product that is damaged or defective upon delivery, please provide notification within 2 days after receiving the product via email website@materialdesaster.com before sending the item back.

You may use other shipping services for item returns. To ensure we receive the items you send, please request a tracking number from the sender and confirm it to us again via email website@materialdesaster.com along with your PAYMENT CONFIRMATION number.

Please repack your return items safely.

Send your return items to the address: Material Desaster Jl. Wira Angun Angun No 4. Bandung.

New items will only be shipped after we receive your exchange items and confirm your return or exchange.

We are not responsible for lost return items during return shipping.

Initial shipping costs cannot be refunded.',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'section_key' => 'exchange_policy',
                'title_id' => 'KEBIJAKAN PENUKARAN BARANG',
                'title_en' => 'EXCHANGE POLICY',
                'content_id' => 'Kami hanya dapat menukar barang yang terspat kerusakan atau cacat tidak menerima penukaran size.

Apabila barang yang bersinggungan telah habis, dana akan dikembalikan penuh dikurangi biaya pengiriman awal setelah kami menerima pengembalian barang anda.

Kami tidak bertanggungjawab atas kehilangan barang pengembalian saat pengiriman kembali.',
                'content_en' => 'We can only exchange items that are damaged or defective. We do not accept size exchanges.

If the replacement item is out of stock, a full refund will be provided minus the initial shipping cost after we receive your returned item.

We are not responsible for lost return items during return shipping.',
                'order' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($policies as $policy) {
            RefundPolicy::create($policy);
        }
    }
}
