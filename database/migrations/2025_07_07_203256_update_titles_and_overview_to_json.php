<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. أضف أعمدة json مؤقتة
        Schema::table('entertainments', function (Blueprint $table) {
            $table->json('title_json')->nullable()->after('title');
            $table->json('overview_json')->nullable()->after('overview');
        });

        // 2. ترحيل البيانات القديمة إلى json المؤقت
        DB::table('entertainments')->orderBy('id')->chunk(100, function ($rows) {
            foreach ($rows as $row) {
                $lang = $row->original_language ?? 'en';

                $title = $row->title ?? $row->original_title ?? null;
                $originalTitle = $row->original_title ?? $title;
                $overview = $row->overview ?? null;

                $titleJson = $lang === 'ar'
                    ? ['ar' => $title, 'en' => $originalTitle]
                    : ['en' => $title, 'ar' => $originalTitle];

                $overviewJson = $lang === 'ar'
                    ? ['ar' => $overview, 'en' => null]
                    : ['en' => $overview, 'ar' => null];

                DB::table('entertainments')
                    ->where('id', $row->id)
                    ->update([
                        'title_json' => json_encode($titleJson),
                        'overview_json' => json_encode($overviewJson),
                    ]);
            }
        });

//        // 3. تعديل نوع الأعمدة الأصلية إلى json
//        // (استخدم raw SQL هنا لأن Laravel لا يدعم change() مباشرة لنوع json)
//        DB::statement('ALTER TABLE entertainments MODIFY title JSON NULL');
//        DB::statement('ALTER TABLE entertainments MODIFY overview JSON NULL');
//
//        // 4. نسخ البيانات من *_json إلى الحقول الأصلية
//        DB::table('entertainments')->orderBy('id')->chunk(100, function ($rows) {
//            foreach ($rows as $row) {
//                DB::table('entertainments')
//                    ->where('id', $row->id)
//                    ->update([
//                        'title' => $row->title_json,
//                        'overview' => $row->overview_json,
//                    ]);
//            }
//        });

//        // 5. (اختياري) حذف الأعمدة المؤقتة
//        Schema::table('entertainments', function (Blueprint $table) {
//            $table->dropColumn(['title_json', 'overview_json']);
//        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('entertainments', function (Blueprint $table) {
            //
        });
    }
};
