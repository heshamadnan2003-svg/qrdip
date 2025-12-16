<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * عرض لوحة التحكم الرئيسية
     */
    public function index()
    {
        // بيانات افتراضية للعرض (يمكنك استبدالها ببيانات حقيقية من قاعدة البيانات)
        $stats = [
            'todayOrders' => 25,
            'totalCustomers' => 142,
            'revenue' => 2450,
            'rating' => 4.8
        ];
        
        // مثال لبيانات الطلبات
        $recentOrders = [
            [
                'id' => '#12345',
                'customer' => 'أحمد محمد',
                'total' => '$45.00',
                'status' => 'مكتمل',
                'date' => now()->format('Y-m-d H:i')
            ],
            [
                'id' => '#12346',
                'customer' => 'سارة خالد',
                'total' => '$32.50',
                'status' => 'قيد التنفيذ',
                'date' => now()->subMinutes(30)->format('Y-m-d H:i')
            ],
            [
                'id' => '#12347',
                'customer' => 'محمد علي',
                'total' => '$67.80',
                'status' => 'مكتمل',
                'date' => now()->subHours(2)->format('Y-m-d H:i')
            ]
        ];
        
        return view('dashboard', [
            'stats' => $stats,
            'recentOrders' => $recentOrders,
            'user' => Auth::user()
        ]);
    }
    
    /**
     * عرض إحصائيات مفصلة
     */
    public function stats()
    {
        // هنا يمكنك إضافة منطق الإحصائيات
        return view('dashboard.stats', [
            'title' => 'الإحصائيات المفصلة'
        ]);
    }
    
    /**
     * عرض التقارير
     */
    public function reports()
    {
        return view('dashboard.reports', [
            'title' => 'التقارير'
        ]);
    }
}