<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'الفواتير',
            'قائمة الفواتير',
            'الفواتير المدفوعة',
            'الفواتير الغير مدفوعة',
            'الفواتير المدفوعة جزئيا',
            'ارشيف الفواتير',
            'اضافة فاتورة',
            'تصدير ExceL',
            'تعديل الفاتورة',
            'تغير حالة الدفع',
            'ارشفة الفاتورة',
            'طباعةالفاتورة',
            'حذف الفاتورة',
            'استرجاع فاتورة',
            'اضافة مرفق',
            'حذف المرفق',
            'التقارير',
            'تقارير الفواتير',
            'تقارير العملاء',
            'المستخدمين',
            'قائمة المستخدمين',
            'اضافة مستخدم',
            'تعديل مستخدم',
            'حذف مستخدم',
            'صلاحيات المستخدمين',
            'عرض رتبة',
            'اضافة رتبة',
            'تعديل رتبة',
            'حذف رتبة',
            'الاعدادات',
            'الاقسام',
            'اضافة قسم',
            'تعديل قسم',
            'حذف قسم',
            'المنتجات',
            'اضافة منتج',
            'تعديل منتج',
            'حذف منتج',
            'الاشعارات',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
