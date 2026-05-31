<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Payment;
use App\Models\Project;
use App\Models\Ticket;
use App\Models\TicketAssignment;
use App\Models\TicketReply;
use App\Models\TicketStatusLog;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['phone' => '09111111111'],
            [
                'name' => 'مدیر مجموعه جهش',
                'role' => 'admin',
                'password' => Hash::make('12345678'),
            ]
        );

        $websiteManager = User::updateOrCreate(
            ['phone' => '09112223344'],
            [
                'name' => 'مدیر وبسایت جهش',
                'role' => 'website_manager',
                'password' => Hash::make('12345678'),
            ]
        );

        $staffUsers = collect([
            ['name' => 'علی پشتیبان', 'phone' => '09120000001'],
            ['name' => 'سارا کارشناس فنی', 'phone' => '09120000002'],
            ['name' => 'مهدی مالی', 'phone' => '09120000003'],
        ])->map(fn (array $staff) => User::updateOrCreate(
            ['phone' => $staff['phone']],
            [
                'name' => $staff['name'],
                'role' => 'staff',
                'password' => Hash::make('12345678'),
            ]
        ));

        $customers = collect([
            [
                'name' => 'شرکت آرمان تجارت',
                'company_name' => 'آرمان تجارت ایرانیان',
                'phone' => '09130000001',
                'address' => 'تهران، خیابان ولیعصر، پلاک ۱۰',
                'projects' => [
                    ['title' => 'فروشگاه اینترنتی آرمان', 'description' => 'پشتیبانی و توسعه فروشگاه آنلاین', 'initial_fee' => 45000000, 'monthly_fee' => 12000000, 'debt_adjustment' => 3000000, 'credit_adjustment' => 0, 'finance_note' => 'مانده بابت توسعه ماژول گزارش'],
                    ['title' => 'باشگاه مشتریان آرمان', 'description' => 'سامانه امتیازدهی و پیامک مشتریان', 'initial_fee' => 28000000, 'monthly_fee' => 8500000, 'debt_adjustment' => 0, 'credit_adjustment' => 1500000, 'finance_note' => 'بستانکاری بابت پرداخت اضافه'],
                ],
            ],
            [
                'name' => 'کلینیک مهر',
                'company_name' => 'کلینیک تخصصی مهر',
                'phone' => '09130000002',
                'address' => 'اصفهان، خیابان چهارباغ، ساختمان مهر',
                'projects' => [
                    ['title' => 'نوبت‌دهی آنلاین مهر', 'description' => 'سامانه رزرو نوبت و پرونده بیماران', 'initial_fee' => 35000000, 'monthly_fee' => 9500000, 'debt_adjustment' => 0, 'credit_adjustment' => 0, 'finance_note' => null],
                ],
            ],
            [
                'name' => 'گروه آموزشی دانا',
                'company_name' => 'موسسه آموزشی دانا',
                'phone' => '09130000003',
                'address' => 'شیراز، بلوار فرهنگ شهر',
                'projects' => [
                    ['title' => 'LMS دانا', 'description' => 'سامانه آموزش آنلاین و آزمون', 'initial_fee' => 52000000, 'monthly_fee' => 15000000, 'debt_adjustment' => 5000000, 'credit_adjustment' => 0, 'finance_note' => 'بدهی بابت افزایش فضای ذخیره‌سازی'],
                    ['title' => 'وبسایت معرفی دوره‌ها', 'description' => 'لندینگ و ثبت‌نام دوره‌ها', 'initial_fee' => 18000000, 'monthly_fee' => 6000000, 'debt_adjustment' => 0, 'credit_adjustment' => 0, 'finance_note' => null],
                ],
            ],
        ])->map(function (array $item) {
            $projectItems = $item['projects'];
            unset($item['projects']);

            $customer = Customer::updateOrCreate(
                ['phone' => $item['phone']],
                $item + ['status' => 'active']
            );

            User::updateOrCreate(
                ['phone' => $customer->phone],
                [
                    'customer_id' => $customer->id,
                    'name' => $customer->name,
                    'role' => 'customer',
                    'password' => Hash::make('12345678'),
                ]
            );

            foreach ($projectItems as $project) {
                Project::updateOrCreate(
                    ['customer_id' => $customer->id, 'title' => $project['title']],
                    array_merge([
                        'initial_fee' => 0,
                        'monthly_fee' => 0,
                        'debt_adjustment' => 0,
                        'credit_adjustment' => 0,
                        'finance_note' => null,
                        'status' => 'active',
                    ], $project)
                );
            }

            return $customer->fresh(['users', 'projects']);
        });

        $ticketSamples = [
            [
                'customer' => 0,
                'project' => 0,
                'staff' => 0,
                'title' => 'خطا در ثبت سفارش فروشگاه',
                'description' => 'مشتری بعد از انتخاب درگاه پرداخت به صفحه خطا منتقل می‌شود.',
                'priority' => 'high',
                'status' => 'in_progress',
                'reply' => 'موضوع بررسی شد؛ مشکل از تنظیمات Callback درگاه است و در حال اصلاح هستیم.',
                'internal' => 'با تیم پرداخت هماهنگ شود و لاگ‌های درگاه بررسی گردد.',
            ],
            [
                'customer' => 1,
                'project' => 0,
                'staff' => 1,
                'title' => 'نیاز به تغییر متن پیامک نوبت‌دهی',
                'description' => 'لطفاً متن پیامک یادآوری نوبت برای بیماران تغییر کند.',
                'priority' => 'medium',
                'status' => 'answered',
                'reply' => 'متن پیشنهادی اعمال شد. لطفاً یک نوبت تست ثبت کنید.',
                'internal' => 'در صورت تایید مشتری، نسخه تولید منتشر شود.',
            ],
            [
                'customer' => 2,
                'project' => 0,
                'staff' => 1,
                'title' => 'آپلود نشدن فایل کلاس',
                'description' => 'مدرس‌ها هنگام آپلود ویدئوهای حجیم خطا دریافت می‌کنند.',
                'priority' => 'high',
                'status' => 'waiting_customer',
                'reply' => 'لطفاً حجم فایل و فرمت ویدئو را ارسال کنید تا محدودیت سرور بررسی شود.',
                'internal' => 'احتمالاً نیاز به افزایش upload_max_filesize روی سرور دارد.',
            ],
        ];

        foreach ($ticketSamples as $sample) {
            $customer = $customers[$sample['customer']];
            $customerUser = $customer->users->firstWhere('role', 'customer');
            $project = $customer->projects[$sample['project']];
            $staff = $staffUsers[$sample['staff']];

            $ticket = Ticket::updateOrCreate(
                ['title' => $sample['title'], 'customer_id' => $customer->id],
                [
                    'project_id' => $project->id,
                    'created_by' => $customerUser->id,
                    'assigned_to' => $staff->id,
                    'description' => $sample['description'],
                    'phone' => $customer->phone,
                    'priority' => $sample['priority'],
                    'status' => $sample['status'],
                ]
            );

            TicketAssignment::updateOrCreate(
                ['ticket_id' => $ticket->id, 'assigned_to' => $staff->id],
                [
                    'assigned_by' => $websiteManager->id,
                    'note' => 'لطفاً این مورد را با اولویت پیگیری کنید.',
                ]
            );

            TicketReply::updateOrCreate(
                ['ticket_id' => $ticket->id, 'user_id' => $staff->id, 'message' => $sample['reply']],
                ['is_internal' => false]
            );

            TicketReply::updateOrCreate(
                ['ticket_id' => $ticket->id, 'user_id' => $staff->id, 'message' => $sample['internal']],
                ['is_internal' => true]
            );

            TicketStatusLog::updateOrCreate(
                ['ticket_id' => $ticket->id, 'new_status' => $sample['status']],
                [
                    'changed_by' => $staff->id,
                    'old_status' => 'open',
                ]
            );
        }

        $payments = [
            ['customer' => 0, 'project' => 0, 'amount' => 12000000, 'payment_month' => '1405/03', 'paid_at' => '2026-05-21', 'status' => 'approved'],
            ['customer' => 0, 'project' => 1, 'amount' => 8500000, 'payment_month' => '1405/03', 'paid_at' => '2026-05-23', 'status' => 'pending'],
            ['customer' => 1, 'project' => 0, 'amount' => 9500000, 'payment_month' => '1405/02', 'paid_at' => '2026-04-30', 'status' => 'approved'],
            ['customer' => 2, 'project' => 0, 'amount' => 15000000, 'payment_month' => '1405/03', 'paid_at' => '2026-05-25', 'status' => 'rejected', 'admin_note' => 'رسید خوانا نیست.'],
        ];

        foreach ($payments as $payment) {
            $customer = $customers[$payment['customer']];
            $project = $customer->projects[$payment['project']];

            Payment::updateOrCreate(
                ['customer_id' => $customer->id, 'project_id' => $project->id, 'payment_month' => $payment['payment_month']],
                [
                    'amount' => $payment['amount'],
                    'paid_at' => $payment['paid_at'],
                    'status' => $payment['status'],
                    'admin_note' => $payment['admin_note'] ?? null,
                    'approved_by' => in_array($payment['status'], ['approved', 'rejected']) ? $admin->id : null,
                ]
            );
        }
    }
}
