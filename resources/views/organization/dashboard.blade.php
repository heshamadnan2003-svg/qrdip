<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - {{ $user->name ?? 'مستخدم' }}</title>
    <!-- CSS links -->
</head>
<body>
    <!-- ... باقي الهيدر ... -->
    
    <!-- Stats Cards - استخدام البيانات المرسلة من الـ Controller -->
    <div class="row">
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-shopping-cart"></i> الطلبات اليوم</h5>
                    <h2 class="card-text">{{ $stats['todayOrders'] ?? 0 }}</h2>
                    <p class="card-text">+5 منذ الأمس</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-users"></i> العملاء</h5>
                    <h2 class="card-text">{{ $stats['totalCustomers'] ?? 0 }}</h2>
                    <p class="card-text">+12 هذا الشهر</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-dollar-sign"></i> الإيرادات</h5>
                    <h2 class="card-text">${{ $stats['revenue'] ?? 0 }}</h2>
                    <p class="card-text">+15% هذا الأسبوع</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-star"></i> التقييم</h5>
                    <h2 class="card-text">{{ $stats['rating'] ?? 0 }}</h2>
                    <p class="card-text">من 5 نجوم</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders - استخدام البيانات المرسلة -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-clock"></i> الطلبات الحديثة</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>رقم الطلب</th>
                                    <th>العميل</th>
                                    <th>المجموع</th>
                                    <th>الحالة</th>
                                    <th>التاريخ</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td>{{ $order['id'] }}</td>
                                    <td>{{ $order['customer'] }}</td>
                                    <td>{{ $order['total'] }}</td>
                                    <td>
                                        <span class="badge bg-{{ $order['status'] == 'مكتمل' ? 'success' : 'warning' }}">
                                            {{ $order['status'] }}
                                        </span>
                                    </td>
                                    <td>{{ $order['date'] }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                            </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ... باقي الصفحة ... -->
</body>
</html>