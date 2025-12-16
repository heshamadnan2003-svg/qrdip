<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #333;
            min-height: 100vh;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 20px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        
        .welcome {
            font-size: 28px;
            color: #667eea;
            margin-bottom: 10px;
        }
        
        .user-info {
            color: #666;
            font-size: 16px;
        }
        
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            text-align: center;
            transition: transform 0.3s;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-title {
            color: #764ba2;
            font-size: 16px;
            margin-bottom: 10px;
        }
        
        .stat-value {
            color: #667eea;
            font-size: 32px;
            font-weight: bold;
        }
        
        .orders-container {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }
        
        .section-title {
            color: #764ba2;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            background: #f8f9fa;
            color: #667eea;
            padding: 15px;
            text-align: right;
        }
        
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }
        
        .status-badge {
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
        }
        
        .status-completed {
            background: #d4edda;
            color: #155724;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        
        .logout-btn {
            background: #ff6b6b;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 30px;
            transition: background 0.3s;
        }
        
        .logout-btn:hover {
            background: #ff5252;
        }
        
        .actions {
            text-align: center;
            margin-top: 40px;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }
            
            .header {
                padding: 20px;
            }
            
            .stats-container {grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="welcome">🎉 أهلاً بك في ل,,,,,,,وحة التحكم</h1>
            <p class="user-info">
                {{ $user->name ?? 'مستخدم' }} - 
                <span style="color: #667eea;">{{ $user->email ?? 'بريد إلكتروني' }}</span>
            </p>
            <p>تاريخ الدخول: {{ now()->format('Y-m-d H:i') }}</p>
        </div>
        
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-title">الطلبات اليوم</div>
                <div class="stat-value">{{ $stats['todayOrders'] ?? 0 }}</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-title">إجمالي العملاء</div>
                <div class="stat-value">{{ $stats['totalCustomers'] ?? 0 }}</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-title">الإيرادات</div>
                <div class="stat-value">${{ $stats['revenue'] ?? 0 }}</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-title">التقييم</div>
                <div class="stat-value">{{ $stats['rating'] ?? 0 }}/5</div>
            </div>
        </div>
        
        <div class="orders-container">
            <h2 class="section-title">📋 الطلبات الحديثة</h2>
            
            @if(isset($recentOrders) && count($recentOrders) > 0)
            <table>
                <thead>
                    <tr>
                        <th>رقم الطلب</th>
                        <th>العميل</th>
                        <th>المجموع</th>
                        <th>الحالة</th>
                        <th>التاريخ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                    <tr>
                        <td>{{ $order['id'] }}</td>
                        <td>{{ $order['customer'] }}</td>
                        <td>{{ $order['total'] }}</td>
                        <td>
                            <span class="status-badge 
                                {{ $order['status'] == 'مكتمل' ? 'status-completed' : 'status-pending' }}">
                                {{ $order['status'] }}
                            </span>
                        </td>
                        <td>{{ $order['date'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p style="text-align: center; color: #666; padding: 20px;">
                لا توجد طلبات حديثة
            </p>
            @endif
        </div>
        
        <div class="actions">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">🚪 تسجيل الخروج</button>
            </form>
        </div>
    </div>

    <script>
        // إضافة بعض التفاعلية
        document.addEventListener('DOMContentLoaded', function() {
            console.log('لوحة التحكم جاهزة!');
            
            // تحديث الوقت كل دقيقة
            function updateTime() {
                const now = new Date();
                const timeElement = document.querySelector('.user-info');
                if (timeElement) {
                    const timeText = timeElement.innerHTML.split(' - ')[0];
                    timeElement.innerHTML = timeText + ' - ' + now.toLocaleTimeString('ar-SA');
                }
            }
            
            // تحديث الوقت أول مرة
            updateTime();
            
            // تحديث كل دقيقة
            setInterval(updateTime, 60000);// تأثير عند التمرير على البطاقات
            const cards = document.querySelectorAll('.stat-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.style.boxShadow = '0 15px 30px rgba(0, 0, 0, 0.15)';
                });
                
                card.addEventListener('mouseleave', () => {
                    card.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.08)';
                });
            });
        });
    </script>
</body>
</html>